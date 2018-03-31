<?php
/**
 */

namespace App\Form\Type;


use App\Entity\Subject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SelectSubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subject_title', EntityType::class, [
                'label' => 'Titre du sujet',
                'class' => Subject::class,
                'choice_label' => 'title',
                'placeholder' =>"",
                'multiple' => false,
            ] );
    }
}