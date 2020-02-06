<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name', TextType::class, [
                'label' => 'Naam',
            ])
            ->add('code', TextType::class, [
                'label' => 'Code',
                'data' => $options['input'],
            ])
            ->add('category', EntityType::class, [
                'label' => 'Categorie',
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Beschrijving',
                'required' => false,
            ])
//            ->add('image', FileType::class, [
//                'label' => 'Afbeelding',
//                'required' => false,
//                'constraints' => [
//                    new File([
//                        'maxSize' => '1024k',
//                        'mimeTypes' => [
//                            'image/png',
//                            'image/jpeg',
//
//                        ],
//                        'mimeTypesMessage' => 'Dit type bestand is helaas niet toegestaan.',
//                    ])
//                ],
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'input' => null,
        ]);
    }
}
