<?php

namespace App\Form;

use App\Entity\MainHeading;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MainHeadingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('systems')
            ->add('location')
            ->add('heatingAppliance')
            ->add('information')
            ->add('createdAt')
            ->add('project')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MainHeading::class,
        ]);
    }
}
