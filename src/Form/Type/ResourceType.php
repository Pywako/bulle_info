<?php
/**
 */

namespace App\Form\Type;


use App\Entity\Resource;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResourceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Titre de la ressource'
            ))
            ->add('summary', TextareaType::class, array(
                'label' => 'Description : la ressource en quelques mots'
            ))
            ->add('link', UrlType::class, array(
                'label' => 'Lien'
            ))
            ->add('tag', TextType::class, array(
                'label' => 'Etiquettes'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Resource::class,
        ));
    }

}
