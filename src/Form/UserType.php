<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                "firstname",
                TextType::class,
                array(
                    "required" => true,
                    "label" => "Prénom de l'utilisateur :",
                    "attr" => array(
                        "class" => "form-control"
                    )
                )
            )
            ->add(
                "lastname",
                TextType::class,
                array(
                    "required" => true,
                    "label" => "Nom de l'utilisateur :",
                    "attr" => array(
                        "class" => "form-control"
                    )
                )
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
