<?php

namespace App\Form;

use App\Entity\Task;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('month', DateType::class, [
                'attr' => [
                    'class' => 'inputForm'
                ]
            ])

            ->add('time', TimeType::class, [
                'input' => 'datetime',
                'widget' => 'choice'
            ])
            ->add('taskName', TextType::class, [
                'attr' => [
                  'class' => 'inputForm'
                ]
              ])
            // ->add('user', TextType::class, [
            //     'attr' => [
            //       'class' => 'inputForm'
            //     ]
            //   ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' =>'clientName'
              ])
            ->add('save', SubmitType::class, ['label' => 'Edit task']);

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
