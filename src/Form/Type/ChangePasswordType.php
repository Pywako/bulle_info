<?php
/**
 */

namespace App\Form\Type;


use App\Entity\ChangePassword;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, array(
                'label' => 'Ancient mot de passe'
            ))
            ->add('newPassword', RepeatedType::class,  array(
                'type' =>PasswordType::class,
                'first_options' => array('label' => 'Nouveau Mot de passe'),
                'second_options' => array('label' => 'Confirmation du mot de passe'),
            ))
            ;

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'validation_groups' => array('changePassword'),
            'data_class' => User::class
        ]);

    }

}