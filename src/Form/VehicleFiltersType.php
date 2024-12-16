<?php declare(strict_types=1);

namespace App\Form;

use App\Entity\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class VehicleFiltersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $filters = $options['data'] ?? [];

        $builder
            ->add('brand', ChoiceType::class, [
                'label' => 'Marque',
                'choices' => [
                    'Ford' => 'Ford',
                    'Toyota' => 'Toyota',
                    'BMW' => 'BMW',
                    'Chevrolet' => 'Chevrolet',
                    'Nissan' => 'Nissan'
                ],
                'placeholder' => 'Toutes les marques',
                'required' => false,
                'attr' => [
                    'value' => $filters['brand'] ?? ''
                ]
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'label',
                'label' => 'Type',
                'placeholder' => 'Tous les types',
                'required' => false,
                'attr' => [
                    'value' => $filters['type'] && $filters['type']->getId() ?? ''
                ]
            ])
            ->add('seats_amount', ChoiceType::class, [
                'label' => 'Nombre de places',
                'choices' => [
                    '2 places' => 2,
                    '4 places' => 4,
                    '5 places' => 5
                ],
                'placeholder' => 'Toutes places',
                'required' => false,
                'attr' => [
                    'value' => $filters['seats_amount'] ?? ''
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Filtrer'
            ]);
    }
}