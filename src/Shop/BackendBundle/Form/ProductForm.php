<?php

namespace Shop\BackendBundle\Form;

use Shop\BackendBundle\Model\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", TextType::class, ["label" => "Intitulé*"])
            ->add("reference", TextType::class, ["label" => "Référence*"])
            ->add("description", TextareaType::class, ["label" => "Description*"])
            ->add("price", TextType::class, ["label" => "Prix*"])
            ->add(
                "measure",
                ChoiceType::class,
                [
                    "label"   => "Unité de mesure",
                    "choices" => [
                        "unité"       => "unit",
                        "g"           => "g",
                        "kg"          => "kg",
                        "tonne"       => "tone",
                        "centimètre"  => "centimeter",
                        "mètre"       => "meter",
                        "mètre carré" => "square meter",
                        "litre"       => "liter",
                        "mètre cube"  => "cubic meter",
                    ],
                ]
            )
            ->add("unit", TextType::class, ["label" => "Quantité par unité de mesure*"])
            ->add("submit", SubmitType::class, ["label" => "Enregistrer"]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Product::class]);
    }

    public function getName()
    {
        return 'shop_backend_bundle_product_form';
    }
}
