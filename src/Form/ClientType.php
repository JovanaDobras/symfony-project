<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('avatar', TextType::class, [
                'attr' => [
                    'class' => 'inputForm'
                ]
            ])
            ->add('clientName', TextType::class, [
                'attr' => [
                    'class' => 'inputForm'
                ]
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'class' => 'inputForm'
                ]
            ])
            ->add('paymentMethod', TextType::class, [
                'attr' => [
                'class' => 'inputForm'
                ]
                ])

            ->add('bankAcount', TextType::class, [
                'attr' => [
                    'class' => 'inputForm'
                ]
            ])

            ->add('save', SubmitType::class, ['label' => 'Add client']);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
