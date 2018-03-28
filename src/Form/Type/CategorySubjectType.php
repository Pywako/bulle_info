<?php
/**
 */

namespace App\Form\Type;


use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class CategorySubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title_category', EntityType::class, [
                'label' => 'Catégorie',
                'class' => Category::class,
                'choice_label' => 'title',
                'multiple' => true,
                'placeholder' => '',
            ])
            ->add('subject_type', ChoiceType::class,[
                'label' => 'Choisir une option de sujet',
                'choices' => [
                    'nouveau sujet' => true,
                    'sélectionner un sujet' => false
                ]
            ])
        ;
    }

}
