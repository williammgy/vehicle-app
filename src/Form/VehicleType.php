<?php declare(strict_types=1);

namespace App\Form;

use App\Entity\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Validator\Constraints as Assert;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('label', TextType::class, [
                'label' => 'Label',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'The label is required.'
                    ])
                ]
            ])
            ->add('brand', ChoiceType::class, [
                'label' => 'Marque',
                'choices' => [
                    'Ford' => 'Ford',
                    'Toyota' => 'Toyota',
                    'BMW' => 'BMW',
                    'Chevrolet' => 'Chevrolet',
                    'Nissan' => 'Nissan'
                ]
            ])
            ->add('seats_amount', ChoiceType::class, [
                'label' => 'Nombre de places',
                'choices' => [
                    '2 places' => 2,
                    '4 places' => 4,
                    '5 places' => 5
                ]
            ])
            ->add('color', TextType::class, [
                'label' => 'Color',
                'required' => false
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'label',
                'constraints' => [
                    new Assert\NotBlank([
                        'message' => 'The type is required.'
                    ])
                ]
            ])
            ->add('gvwr', NumberType::class, [
                'label' => 'GVWR',
                'scale' => 2,
                'required' => false,
                'constraints' => [
                    new Assert\Positive([
                        'message' => 'The GVWR cannot be negative.',
                    ])
                ],
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Save'
            ]);
    }
}