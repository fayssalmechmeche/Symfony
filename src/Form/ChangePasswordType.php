<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Mon email',
                'constraints' => [new Length(null, 8, 50), new NotBlank()],
                'required' => true,
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mon mot de passe',
                'constraints' => [new Length(null, 8, 15), new NotBlank(), new NotCompromisedPassword()],
                'required' => true,
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Mon prénom',
                'constraints' => [new Length(null, 3, 15), new NotBlank()],
                'required' => true,
            ])
            ->add('nom', TextType::class, [
                'label' => 'Mon nom',
                'constraints' => [new Length(null, 3, 15), new NotBlank()],
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Changez mes informations",

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
