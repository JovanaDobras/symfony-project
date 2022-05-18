<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('avatar', FileType::class, [
            'attr' => [
              'class' => 'inputForm'
            ],
            'label' => 'Profile image',
            'mapped' => false,
            'required' => false,
            'constraints' => [
              new File([
                'maxSize' => '10024k',
                'mimeTypes' => [
                  'image/gif',
                  'image/png',
                  'image/svg',
                  'image/jpeg',
                ],
                'mimeTypesMessage' => 'Please upload a valid image document'
              ])
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
