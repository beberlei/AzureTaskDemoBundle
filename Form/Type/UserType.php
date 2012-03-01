<?php

namespace WindowsAzure\TaskDemoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class UserType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('password', 'password')
        ;
    }

    public function getName()
    {
        return 'azure_user';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'WindowsAzure\TaskDemoBundle\Entity\User',
        );
    }
}

