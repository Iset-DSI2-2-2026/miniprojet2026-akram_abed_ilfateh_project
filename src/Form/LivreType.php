<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => ['class' => 'form-control', 'required' => true]
            ])
            ->add('resume', TextareaType::class, [
                'label' => 'Résumé',
                'attr' => ['class' => 'form-control', 'rows' => 5, 'required' => true]
            ])
            ->add('isbn', TextType::class, [
                'label' => 'ISBN',
                'attr' => ['class' => 'form-control', 'required' => true]
            ])
            ->add('nbPages', IntegerType::class, [
                'label' => 'Nombre de pages',
                'attr' => ['class' => 'form-control', 'required' => true]
            ])
            ->add('datePublication', DateType::class, [
                'label' => 'Date de publication',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control', 'required' => true]
            ])
            ->add('disponible', CheckboxType::class, [
                'label' => 'Disponible',
                'required' => false,
                'attr' => ['class' => 'form-check-input']
            ])
            ->add('auteur', EntityType::class, [
                'label' => 'Auteur',
                'class' => Auteur::class,
                'choice_label' => 'fullName',
                'attr' => ['class' => 'form-select', 'required' => true]
            ])
            ->add('genre', EntityType::class, [
                'label' => 'Genre',
                'class' => Genre::class,
                'choice_label' => 'nom',
                'attr' => ['class' => 'form-select', 'required' => true]
            ])
            ->add('tags', EntityType::class, [
                'label' => 'Tags',
                'class' => Tag::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'required' => false,
                'attr' => ['class' => 'form-select']
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image de couverture',
                'mapped' => false,
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
