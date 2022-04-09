<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Trainer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('name', TextType::class, [
                    'constraints' => [
                        new Assert\Length([
                            'min'        => 2,
                            'minMessage' => "min 2 caractere",
                            'max'        => 255,
                            'maxMessage' => "trop grand",
                        ]),
                    ]
                ])
                ->add('numTVA', IntegerType::class)

                ->add('trainers', TrainerType::class, [
                        'data_class' => Trainer::class,
                        'mapped' => false
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
                'data_class' => Company::class,
        ]);
    }
}
