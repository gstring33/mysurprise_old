<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'required' => true,
                'label' => 'Vorname'
            ])
            ->add('lastname', TextType::class, [
                'required' => true,
                'label' => 'Nachname'
            ])
            ->add('password', TextType::class, [
                'required' => true,
                'label' => 'Passwort'
            ])
            ->add('image', TextType::class, [
                'required' => true,
                'label' => 'Build'
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => 'Email'
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
