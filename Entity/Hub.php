<?php

namespace AmaxLab\Oro\Bundle\AtolHubBundle\Entity;

use AmaxLab\Oro\Bundle\AtolHubBundle\Model\ExtendHub;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @author Egor Zyuskin <ezyuskin@amaxlab.ru>
 * @ORM\Table(name="amaxlab_atol_hub")
 * @ORM\Entity(repositoryClass="AmaxLab\Oro\Bundle\AtolHubBundle\Entity\Repository\HubRepository")
 */
class Hub extends ExtendHub
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="ip", type="string")
     */
    private $ip;

    /**
     * @var string
     * @ORM\Column(name="username", type="string")
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(name="password", type="string")
     */
    private $password;

    /**
     * @var DateTime
     * @ORM\Column(name="update_system_info_time", type="datetime", nullable=true)
     */
    private $updateSystemInfoTime;

    /**
     * @var string
     * @ORM\Column(name="factory_number", type="string", length=100, nullable=true)
     */
    private $factoryNumber;

    /**
     * @var string
     * @ORM\Column(name="last_update_time", type="string", length=35, nullable=true)
     */
    private $lastUpdateTime;

    /**
     * @var string
     * @ORM\Column(name="last_check_update_time", type="string", length=35, nullable=true)
     */
    private $lastCheckUpdateTime;

    /**
     * @var boolean
     * @ORM\Column(name="need_update", type="boolean", nullable=true)
     */
    private $needUpdate;

    /**
     * @var string
     * @ORM\Column(name="utm_version", type="string", nullable=true)
     */
    private $utmVersion;

    /**
     * @var boolean
     * @ORM\Column(name="old_version", type="boolean", nullable=true)
     */
    private $oldVersion;

    /**
     * @var bool
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var bool
     * @ORM\Column(name="utm_delete_documents", type="boolean", nullable=true)
     */
    private $utmDeleteDocuments;

    /**
     * @var bool
     * @ORM\Column(name="errors_in_log", type="boolean",  nullable=true)
     */
    private $errorsInLog;

    /**
     * @var HubEvent
     * @ORM\OneToMany(targetEntity="AmaxLab\Oro\Bundle\AtolHubBundle\Entity\HubEvent", mappedBy="hub")
     */
    private $events;

    /**
     * @var bool
     * @ORM\Column(name="alive", type="boolean", nullable=true)
     */
    private $alive;

    /**
     * @var int
     * @ORM\Column(name="rsa_cert_expire_day_count", type="integer", nullable=true)
     */
    private $rsaCertExpireDayCount;

    /**
     * @var int
     * @ORM\Column(name="gost_cert_expire_day_count", type="integer", nullable=true)
     */
    private $gostCertExpireDayCount;

    /**
     * @var bool
     * @ORM\Column(name="cert_expired", type="boolean", nullable=true)
     */
    private $certExpired;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Construct
     */
    public function __construct()
    {
        $this->events = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Hub
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Hub
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return Hub
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Hub
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Hub
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return string
     */
    public function getFactoryNumber()
    {
        return $this->factoryNumber;
    }

    /**
     * @param string $factoryNumber
     */
    public function setFactoryNumber($factoryNumber)
    {
        $this->factoryNumber = $factoryNumber;
    }

    /**
     * @return string
     */
    public function getLastUpdateTime()
    {
        return $this->lastUpdateTime;
    }

    /**
     * @param string $lastUpdateTime
     */
    public function setLastUpdateTime($lastUpdateTime)
    {
        $this->lastUpdateTime = $lastUpdateTime;
    }

    /**
     * @return boolean
     */
    public function isNeedUpdate()
    {
        return $this->needUpdate;
    }

    /**
     * @param boolean $needUpdate
     */
    public function setNeedUpdate($needUpdate)
    {
        $this->needUpdate = $needUpdate;
    }

    /**
     * @return string
     */
    public function getLastCheckUpdateTime()
    {
        return $this->lastCheckUpdateTime;
    }

    /**
     * @param string $lastCheckUpdateTime
     */
    public function setLastCheckUpdateTime($lastCheckUpdateTime)
    {
        $this->lastCheckUpdateTime = $lastCheckUpdateTime;
    }

    /**
     * @return mixed
     */
    public function getUtmDeleteDocuments()
    {
        return $this->utmDeleteDocuments;
    }

    /**
     * @param mixed $utmDeleteDocuments
     */
    public function setUtmDeleteDocuments($utmDeleteDocuments)
    {
        $this->utmDeleteDocuments = $utmDeleteDocuments;
    }

    /**
     * @return bool
     */
    public function isAlive()
    {
        return $this->alive;
    }

    /**
     * @param bool $alive
     */
    public function setAlive($alive)
    {
        $this->alive = $alive;
    }

    /**
     * Get needUpdate
     *
     * @return boolean
     */
    public function getNeedUpdate()
    {
        return $this->needUpdate;
    }

    /**
     * Add events
     *
     * @param HubEvent $events
     * @return Hub
     */
    public function addEvent(HubEvent $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param HubEvent $events
     */
    public function removeEvent(HubEvent $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * @return boolean
     */
    public function isErrorsInLog()
    {
        return $this->errorsInLog;
    }

    /**
     * @param boolean $errorsInLog
     */
    public function setErrorsInLog($errorsInLog)
    {
        $this->errorsInLog = $errorsInLog;
    }

    /**
     * @return string
     */
    public function getUtmVersion()
    {
        return $this->utmVersion;
    }

    /**
     * @param string $utmVersion
     * @return Hub
     */
    public function setUtmVersion($utmVersion)
    {
        $this->utmVersion = $utmVersion;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isOldVersion()
    {
        return $this->oldVersion;
    }

    /**
     * @param boolean $oldVersion
     * @return Hub
     */
    public function setOldVersion($oldVersion)
    {
        $this->oldVersion = $oldVersion;

        return $this;
    }

    /**
     * @return int
     */
    public function getRsaCertExpireDayCount()
    {
        return $this->rsaCertExpireDayCount;
    }

    /**
     * @param int $rsaCertExpireDayCount
     *
     * @return $this
     */
    public function setRsaCertExpireDayCount($rsaCertExpireDayCount)
    {
        $this->rsaCertExpireDayCount = $rsaCertExpireDayCount;

        return $this;
    }

    /**
     * @return int
     */
    public function getGostCertExpireDayCount()
    {
        return $this->gostCertExpireDayCount;
    }

    /**
     * @param int $gostCertExpireDayCount
     *
     * @return $this
     */
    public function setGostCertExpireDayCount($gostCertExpireDayCount)
    {
        $this->gostCertExpireDayCount = $gostCertExpireDayCount;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCertExpired()
    {
        return $this->certExpired;
    }

    /**
     * @param bool $certExpired
     *
     * @return $this
     */
    public function setCertExpired($certExpired)
    {
        $this->certExpired = $certExpired;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getUpdateSystemInfoTime()
    {
        return $this->updateSystemInfoTime;
    }

    /**
     * @param DateTime $updateSystemInfoTime
     *
     * @return $this
     */
    public function setUpdateSystemInfoTime($updateSystemInfoTime)
    {
        $this->updateSystemInfoTime = $updateSystemInfoTime;

        return $this;
    }
}
