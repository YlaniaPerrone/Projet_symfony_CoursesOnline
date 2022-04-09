<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Cours;
use App\Entity\Language;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Time;
use Symfony\Component\Form\FormTypeInterface;

class CoursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EntityType::class,[
                    'class' => Category::class
            ])
            ->add('Title', TextType::class)
            ->add('level', IntegerType::class)
            ->add('price')
            ->add('nbrSession', IntegerType::class)
            ->add('Duration',TimeType::class)
            ->add('Description', TextareaType::class)
            ->add('language', EntityType::class,[
                    'class' => Language::class,
                    'label' => 'langue'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
