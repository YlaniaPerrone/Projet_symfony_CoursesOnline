<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    private $urlGenerator;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [

            ])
            ->add('name', TextType::class)
            ->add('email', EmailType::class)

//            if (!)
//            {
                ->add('password', RepeatedType::class, [
                    'type'            => PasswordType::class,
                    'invalid_message' => 'The password fields must match.',
                    //                        'options'         => ['attr' => ['class' => 'password-field']],
                    'required'        => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a password',
                        ])],
                    'first_options'   => ['label' => 'Password'],
                    'second_options'  => ['label' => 'Repeat Password']
                ]);
//            }

        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
