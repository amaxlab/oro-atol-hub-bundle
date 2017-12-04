<?php

namespace AmaxLab\Oro\Bundle\AtolHubBundle\Form\Type;

use AmaxLab\Oro\Bundle\AtolHubBundle\Entity\Hub;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Egor Zyuskin <ezyuskin@amaxlab.ru>
 */
class HubType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hub::class,
        ]);
    }
}
