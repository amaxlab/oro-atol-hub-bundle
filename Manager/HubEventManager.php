<?php

namespace AmaxLab\Oro\Bundle\AtolHubBundle\Manager;

use AmaxLab\Oro\Bundle\AtolHubBundle\Entity\Hub;
use AmaxLab\Oro\Bundle\AtolHubBundle\Entity\HubEvent;
use DateTime;
use Doctrine\ORM\EntityManager;
use Oro\Bundle\UserBundle\Entity\User;

/**
 * @author Egor Zyuskin <ezyuskin@amaxlab.ru>
 */
class HubEventManager
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param DateTime $time
     * @param string   $message
     * @param User     $user
     * @param Hub      $hub
     * @param string   $state
     */
    public function addEvent(DateTime $time, $message, User $user = null, Hub $hub = null, $state = HubEvent::EVENT_STATE_SUCCESS)
    {
        $event = (new HubEvent())
            ->setTime($time)
            ->setMessage($message)
            ->setState($state)
            ->setUser($user)
            ->setHub($hub)
        ;

        $this->em->persist($event);
        $this->em->flush($event);
    }
}
