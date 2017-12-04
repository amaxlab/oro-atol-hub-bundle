<?php

namespace AmaxLab\Oro\Bundle\AtolHubBundle\Form\Handler;

use AmaxLab\Oro\Bundle\AtolHubBundle\Entity\Hub;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Egor Zyuskin <ezyuskin@amaxlab.ru>
 */
class HubHandler
{
    /**
     * @var FormInterface
     */
    private $form;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * @param FormInterface $form
     * @param Request       $request
     * @param ObjectManager $manager
     */
    public function __construct(FormInterface $form, Request $request, ObjectManager $manager)
    {
        $this->form    = $form;
        $this->request = $request;
        $this->manager = $manager;
    }

    /**
     * Process form
     *
     * @param  Hub $entity
     * @return bool
     */
    public function process(Hub $entity)
    {
        $this->form->setData($entity);

        if (in_array($this->request->getMethod(), [Request::METHOD_POST, Request::METHOD_PUT])) {
            $this->form->submit($this->request);

            if ($this->form->isValid()) {
                $this->manager->persist($entity);
                $this->manager->flush();

                return true;
            }
        }

        return false;
    }
}
