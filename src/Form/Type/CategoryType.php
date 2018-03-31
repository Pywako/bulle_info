<?php
/**
 */

namespace App\Form\Type;


use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', EntityType::class, array(
                'label'         => 'Nom de la catégorie',
                'class'         => Category::class,
                'choice_label'  => 'title',
                'multiple'      => true
            ))
        ;
    }
}
