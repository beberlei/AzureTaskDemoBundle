<?php
namespace WindowsAzure\TaskDemoBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('subject', 'text')
            ->add('type', 'entity', array(
                'class' => 'WindowsAzure\TaskDemoBundle\Entity\TaskType',
                'property' => 'label'
            ))
            ->add('dueDate', 'datetime')
        ;
    }

    public function getName()
    {
        return 'azure_task';
    }
}

