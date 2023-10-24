<?php

namespace App\Form\Product;

use App\Entity\Brands;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
                    'class' => 'form-control',
                    'placeholder' => 'Titre',
                    'id' => 'floatingName'
                ],
                'label' => 'Titre',
                'label_attr' => [
                    'for' => 'floatingName'
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length( min: 2 )
                ]
            ])
            ->add('description', TextAreaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Déscription',
                    'id' => 'floatingTextArea'
                ],
                'label' => 'Déscription',
                'label_attr' => [
                    'for' => 'floatingTextArea'
                ]
                ])
            ->add('quantity_stock', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Stock',
                    'id' => 'floatingNumber',
                ],
                'label' => 'Stock',
                'label_attr' => [
                    'for' => 'floatingNumber'
                ],
                'constraints' => [
                    new Assert\PositiveOrZero()
                ]
            ])
            ->add('price', NumberType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prix',
                    'id' => 'floatingMoney'
                ],
                'label' => 'Prix',
                'label_attr' => [
                    'for' => 'floatingMoney'
                ],
                'constraints' => [
                    new Assert\NotNull(),
                    new Assert\PositiveOrZero()
                ]
            ])
            ->add('types', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Types',
                    'id' => 'floatingTypes'
                ],
                'label' => 'Types',
                'label_attr' => [
                    'for' => 'floatingTypes'
                ]
            ])
            ->add('gender', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Genre',
                    'id' => 'floatingGender'
                ],
                'label' => 'Genre',
                'label_attr' => [
                    'for' => 'floatingGender'
                ]
            ])
            ->add('brands', EntityType::class, [
                'class' => Brands::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Marque',
                    'id' => 'floatingBrands'
                ],
                'label' => 'Marque',
                'label_attr' => [
                    'for' => 'floatingBrands'
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
