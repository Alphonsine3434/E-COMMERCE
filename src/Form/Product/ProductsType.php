<?php

namespace App\Form\Product;

use App\Entity\Brands;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ProductsType extends AbstractType
{

    /**
     * Function to create Formular
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Titre',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length( min: 2 )
                ]
            ])
            ->add('description', TextAreaType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Déscription',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
                ])
            ->add('quantity_stock', NumberType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Quantité de Stock',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\PositiveOrZero()
                ]
            ])
            ->add('price', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Prix',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\Positive()
                ]
            ])
            ->add('types', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Types',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('gender', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Genre',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('brands', EntityType::class, [
                'class' => Brands::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Marque',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Ajouter Produit'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
