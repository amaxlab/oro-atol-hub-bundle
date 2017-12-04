<?php

namespace AmaxLab\Oro\Bundle\AtolHubBundle\Manager;

use AmaxLab\Oro\Bundle\AtolHubBundle\Entity\Hub;
use Craue\ConfigBundle\Util\Config;
use Doctrine\ORM\EntityManager;
use It2k\AtolHubClient\Client;
use DateTime;
use Oro\Bundle\UserBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * @author Egor Zyuskin <ezyuskin@amaxlab.ru>
 */
class HubManager
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var HubEventManager
     */
    private $eventManager;

    /**
     * @var User
     */
    private $currentUser;

    /**
     * @var Config
     */
    private $config;

    /**
     * @param EntityManager $em
     * @param HubEventManager  $eventManager
     * @param TokenStorage  $tokenStorage
     * @param Config        $config
     */
    public function __construct(EntityManager $em, HubEventManager $eventManager, TokenStorage $tokenStorage, Config $config)
    {
        $this->em = $em;
        $this->eventManager = $eventManager;
        $this->currentUser = ($tokenStorage->getToken()) ? $tokenStorage->getToken()->getUser() : null;
        $this->config = $config;
    }

    /**
     * loadHubsInfo
     */
    public function loadHubsInfo()
    {
        $hubs = $this->em->getRepository(Hub::class)->findAll();

        if (count($hubs) > 0) {
            foreach ($hubs as $hub) {
                if ($hub->getActive()) {
                    $this->loadHubInfo($hub, true);
                }
            }
        }
    }

    /**
     * pingHub
     */
    public function pingHub()
    {
        $hubs = $this->em->getRepository(Hub::class)->findAll();
        $flushing = false;
        if (count($hubs) > 0) {
            foreach ($hubs as $hub) {
                $oldState = $hub->isAlive();
                $newState = $this->checkHubAlive($hub);

                if ($oldState != $newState) {
                    $flushing = true;
                    $hub->setAlive($newState);
                    $this->em->persist($hub);
                    $this->addEvent((($newState) ? 'ONLINE' : 'OFFLINE'), $hub, ($newState ? 'success' : 'warning'));
                }

                print $hub->getName().'-'.($newState ? 'ONLINE' : 'OFFLINE')."\n";
            }
        }

        if ($flushing) {
            $this->em->flush();
        }
    }

    /**
     * @param Hub  $hub
     * @param bool $autoFlush
     * @return bool
     */
    public function loadHubInfo(Hub $hub, $autoFlush = true)
    {
        $client = $this->createHubClientFromHub($hub);

        if ($client->getFactoryNumber()) {
            $hub->setFactoryNumber($client->getFactoryNumber());
            $hub->setLastUpdateTime($client->getLastUpdateDate());
            $hub->setLastCheckUpdateTime(($client->getLastCheckUpdateDate()));
            $hub->setNeedUpdate($client->isNeedUpdate());
            $hub->setUtmDeleteDocuments($client->isUtmDeleteDocuments());
            $hub->setUtmVersion($client->getUtmVersion());
            $hub->setOldVersion((version_compare($hub->getUtmVersion(), $this->config->get('hub_old_version_min'), '<'))? true : false);
            $hub->setErrorsInLog($this->findErrorsInLog($client));
            $hub->setRsaCertExpireDayCount($client->getRsaCertExpiredDaysCount());
            $hub->setGostCertExpireDayCount($client->getGostCertExpiredDaysCount());
            $hub->setCertExpired(($hub->getRsaCertExpireDayCount() < $this->config->get('cert_min_day_count') || $hub->getGostCertExpireDayCount() < $this->config->get('cert_min_day_count')) ? true : false);
            $hub->setUpdateSystemInfoTime(new DateTime());

            $this->em->persist($hub);

            if ($autoFlush) {
                $this->em->flush($hub);
            }

            return true;
        }

        $this->addEvent('Обнавление информации завершилось не удачей.', $hub, 'danger');

        return false;
    }

    /**
     * @param Hub $hub
     * @return bool
     */
    public function rebootHub(Hub $hub)
    {
        $client = $this->createHubClientFromHub($hub);
        $rebooted = $client->reboot();

        if ($rebooted) {
            $this->addEvent('Хаб перезагружен', $hub);

            return true;
        }

        $this->addEvent('Ошибка перезагрузки хаба', $hub, 'danger');

        return false;
    }

    /**
     * @param Hub $hub
     * @return bool
     */
    public function clearLog(Hub $hub)
    {
        $client = $this->createHubClientFromHub($hub);

        $cleared = $client->clearUtmLog();
        if ($cleared) {
            $this->addEvent('Очищены логи', $hub);

            return true;
        }

        $this->addEvent('Ошибка очистки логов', $hub, 'danger');

        return false;

    }

    /**
     * @param Hub $hub
     * @return bool
     */
    public function clearLogAndReboot(Hub $hub)
    {
        if ($this->clearLog($hub) && $this->rebootHub($hub)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $message
     * @param Hub    $hub
     * @param string $state
     */
    private function addEvent($message, Hub $hub, $state = '')
    {
        $this->eventManager->addEvent(new DateTime(), $message, $this->currentUser, $hub, $state);
    }

    /**
     * @param Hub $hub
     * @return Client
     */
    private function createHubClientFromHub(Hub $hub)
    {
        return new Client($hub->getIp(), $hub->getUsername(), $hub->getPassword());
    }

    /**
     * @param Client $client
     * @return bool
     */
    private function findErrorsInLog(Client $client)
    {
        $log = $client->getUtmLog();
        $now = new DateTime();

        $pos = strpos($log, 'ERROR es.programador.transport.k - Ошибка проверки состояния Transport Updater');
        while ($pos > 0) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s', substr($log, $pos - 24, 19));

            if ((($date->diff($now)->h * 60) +  $date->diff($now)->i) <= $this->config->get('hub_log_connection_error_intval')) {
                return true;
            }
            $pos = strpos($log, 'ERROR es.programador.transport.k - Ошибка проверки состояния Transport Updater', ($pos + 1));
        }

        return false;
    }

    /**
     * @param Hub $hub
     * @return bool
     */
    private function checkHubAlive(Hub $hub)
    {
        try {
            $handle = fsockopen($hub->getIp(), 80, $error, $errorStr, intval($this->config->get('hub_ping_timeout')));

            return ($handle !== false) ? true : false;
        } catch (\Exception $e) {
            return false;
        }
    }
}
