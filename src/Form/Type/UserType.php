<?php
/**
 */

namespace App\Form\Type;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('userName', TextType::class, array(
                'label' => 'Nom / Pseudo'))
            ->add('email', EmailType::class)
            ->add('plainPassword', RepeatedType::class, array(
                'type' =>PasswordType::class,
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmation mot de passe'),
            ))
            ->add('termsAccepted', CheckboxType::class, array(
                'label' => 'Accepter la charte du site',
                'mapped' => false,
                'constraints' => new IsTrue()
            ))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'date_class' => User::class,
        ));
    }
}