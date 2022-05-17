<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType::class, [
                'attr' => [
                    'class' => 'inputForm'
                ],
            ])

            ->add('roles', ChoiceType::class, [
                'attr' => [
                    'class' => 'inputForm'
                ],
                'multiple' => false,
                'expanded' => false,
                'choices' => [
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ]
            ])

            ->add('password', PasswordType::class, [
                'mapped' => true,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'inputForm'                    
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please eter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{limit }} characters',
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('avatar', TextType::class, [
                'attr' => [
                  'class' => 'inputForm'
                ]
              ])

              ->add('firstName', TextType::class, [
                'attr' => [
                  'class' => 'inputForm'
                ]
              ])

              ->add('lastName', TextType::class, [
                'attr' => [
                  'class' => 'inputForm'
                ]
              ])

              ->add('city', TextType::class, [
                'attr' => [
                  'class' => 'inputForm'
                ]
              ])
              ->add('status', TextType::class, [
                'attr' => [
                  'class' => 'inputForm'
                ]
              ])

            ->add('save', SubmitType::class, ['label' => 'Add user']);


            $builder->get('roles')
                ->addModelTransformer(new CallbackTransformer(
            function ($rolesArray) {
                return count($rolesArray) ? $rolesArray[0] : 0;
            },
            function ($rolesString) {
                return [$rolesString];
         }
      ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
