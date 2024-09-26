<?php

namespace App\Form;

use App\Entity\Course;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,['label'=>'Titre','attr'=>['class'=>'form-control']])
            ->add('content', TextareaType::class,['label'=>'Description','attr'=>['class'=>'form-control'],'required'=>false])
            ->add('duration',IntegerType::class,['label'=>'Durée (jours)','attr'=>['class'=>'form-control']])
            ->add('published',CheckboxType::class,['label'=>'Publié','required'=>false])
            ->add('dateCreated', null, [
                'widget' => 'single_text',
            ])
            ->add('dateModified', null, [
                'widget' => 'single_text',
            ])
            ->add('btnCreate',SubmitType::class,['label'=>'Ajouter','attr'=>['class'=>'btn btn-success']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
