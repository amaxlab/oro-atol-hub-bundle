<?php

namespace AmaxLab\Oro\Bundle\AtolHubBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\UserBundle\Entity\User;

/**
* @author Egor Zyuskin <ezyuskin@amaxlab.ru>
* @ORM\Table(name="amaxlab_atol_hub_event")
* @ORM\Entity(repositoryClass="AmaxLab\Oro\Bundle\AtolHubBundle\Entity\Repository\HubEventRepository")
*/
class HubEvent
{
    const EVENT_STATE_SUCCESS = 'success';

    const EVENT_STATE_WARNING = 'warning';

    const EVENT_STATE_ERROR = 'error';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Hub
     * @ORM\ManyToOne(targetEntity="AmaxLab\Oro\Bundle\AtolHubBundle\Entity\Hub", inversedBy="events")
     */
    private $hub;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     */
    private $user;

    /**
     * @var DateTime
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;

    /**
     * @var string
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var string
     * @ORM\Column(name="state", type="string", nullable=true)
     */
    private $state;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set time
     *
     * @param DateTime $time
     *
     * @return $this
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return $this
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set hub
     *
     * @param Hub $hub
     *
     * @return $this
     */
    public function setHub($hub)
    {
        $this->hub = $hub;

        return $this;
    }

    /**
     * Get hub
     *
     * @return Hub
     */
    public function getHub()
    {
        return $this->hub;
    }

    /**
     * Set user
     *
     * @param User $user
     * 
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }
}
