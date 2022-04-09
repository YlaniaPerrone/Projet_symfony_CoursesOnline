<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Prestation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class PrestationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startTime', TimeType::class,[
//                'data' => new \DateTime('now', new \DateTimeZone('Europe/Paris')),
//                    'format' => 'H:M',
            ])
            ->add('endTime', TimeType::class,[
//                'data' => new \DateTime('now', new \DateTimeZone('Europe/Paris')),
                //                    'format' => 'HH::MM',
            ])
            ->add('startDate', DateType::class,[
                'required' => true,
                'data' => new \DateTime("now"),
//                    'label' => 'start date',
//                    'widget' => 'single_text',
//                    // prevents rendering it as type="date", to avoid HTML5 date pickers
//                    'html5' => false,
                'format' => 'dd-MM-yyyy',
//                    // adds a class that can be selected in JavaScript
//                    'attr' => ['class' => 'js-datepicker'],
            ])
            ->add('endDate', DateType::class,[
                'required' => true,
                'data' => new \DateTime("now"),

//                    'label' => 'start date',
//                    'widget' => 'single_text',
//                    // prevents rendering it as type="date", to avoid HTML5 date pickers
//                    'html5' => false,
//                    'format' => 'dd-MM-yyyy',
//                    // adds a class that can be selected in JavaScript
//                    'attr' => ['class' => 'js-datepicker'],
            ])

            ->add('days', ChoiceType::class, [
                'label' => 'Choose days',
                'choices'  => [
                        'Monday' => 'Monday',
                        'Tuesday ' => 'Tuesday ',
                        'Wednesday ' => 'Wednesday ',
                        'Thursday ' => 'Thursday ',
                        'Friday  ' => 'Friday ',
                        'Saturday   ' => 'Saturday ',
                        'Sunday   ' => 'Sunday  ',
                ],
                'required' => true,
                'multiple' => true,
                'mapped' => false
            ])
            ->add('cours')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prestation::class,
        ]);
    }

    public function checkValidation()
    {

    }
}
