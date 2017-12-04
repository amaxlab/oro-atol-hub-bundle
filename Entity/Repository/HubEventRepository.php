<?php

namespace AmaxLab\Oro\Bundle\AtolHubBundle\Entity\Repository;

use AmaxLab\Oro\Bundle\AtolHubBundle\Entity\Hub;
use Doctrine\ORM\EntityRepository;

/**
 * @author Egor Zyuskin <ezyuskin@amaxlab.ru>
 */
class HubEventRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function findAll()
    {
        return $this->findBy([], ['id' => 'desc']);
    }

    /**
     * @param Hub $hub
     * @param int $limit
     * @return array
     */
    public function getLastByHub(Hub $hub, $limit = 50)
    {
        return $this->findBy(['hub' => $hub], ['id' => 'desc'], $limit);
    }
}
