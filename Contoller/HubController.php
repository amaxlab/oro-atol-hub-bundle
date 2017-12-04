<?php

namespace AmaxLab\Oro\Bundle\AtolHubBundle\Controller;

use AmaxLab\Oro\Bundle\AtolHubBundle\Form\Handler\HubHandler;
use AmaxLab\Oro\Bundle\AtolHubBundle\Entity\Hub;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Egor Zyuskin <ezyuskin@amaxlab.ru>
 * @Route("hub")
 */
class HubController extends Controller
{
    /**
     * @Route(
     *      "/{_format}",
     *      name="atol_hub_index",
     *      requirements={"_format"="html|json"},
     *      defaults={"_format" = "html"}
     * )
     * @AclAncestor("atol_hub_view")
     * @Template
     * @return array
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/view/{id}", name="atol_hub_view", requirements={"id"="\d+"})
     * @Template
     * @Acl(
     *      id="atol_hub_view",
     *      type="entity",
     *      class="AtolHubBundle:Hub",
     *      permission="VIEW"
     * )
     * @param Hub $entity
     * @return array
     */
    public function viewAction(Hub $entity)
    {
        return [
            'entity' => $entity,
            'entityClass' => Hub::class,
        ];
    }

    /**
     * @Route("/widget/info/{id}", name="atol_hub_widget_info", requirements={"id"="\d+"})
     * @Template("AtolHubBundle:Hub/widget:info.html.twig")
     * @AclAncestor("atol_hub_view")
     * @param Hub $entity
     * @return array
     */
    public function infoAction(Hub $entity)
    {
        return [
            'entity' => $entity,
        ];
    }

    /**
     * @Route("/create", name="atol_hub_create")
     * @Template("AtolHubBundle:Hub:update.html.twig")
     * @Acl(
     *      id="atol_hub_create",
     *      type="entity",
     *      class="AtolHubBundle:Hub",
     *      permission="CREATE"
     * )
     * @return array
     */
    public function createAction()
    {
        return $this->update(new Hub());
    }

    /**
     * @Route("/update/{id}", name="atol_hub_update", requirements={"id"="\d+"}, defaults={"id"=0})
     * @Template
     * @Acl(
     *      id="atol_hub_update",
     *      type="entity",
     *      class="AtolHubBundle:Hub",
     *      permission="EDIT"
     * )
     * @param Hub $entity
     * @return array
     */
    public function updateAction(Hub $entity)
    {
        return $this->update($entity);
    }

    /**
     * @param Hub $entity
     * @return array
     */
    protected function update(Hub $entity)
    {
        if ($this->get(HubHandler::class)->process($entity)) {
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('oro.business_unit.controller.message.saved') //TODO:change this
            );

            return $this->get('oro_ui.router')->redirect($entity);
        }

        return [
            'entity' => $entity,
            'entityClass' => Hub::class,
            'form' => $this->get('atol_hub.form.hub')->createView(),
        ];
    }
}
