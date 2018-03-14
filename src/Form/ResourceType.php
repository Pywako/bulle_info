<?php
/**
 */

namespace App\Form;


use App\Entity\Resource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', SubjectType::class, array(
            ))
            ->add('title', TextType::class, array(
                'label' => 'Titre de la ressource'
            ))
            ->add('summary', TextType::class ,array(
                'label' => 'La ressource en quelques mots'
            ))
            ->add('link', TextType::class ,array(
                'label' => 'lien de la ressource'
            ))
            ->add('tag', TextType::class, array(
                'label' => 'tags, permettra de retrouver la ressource par la recherche de mots clés'
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Resource::class,

        ));
    }

}