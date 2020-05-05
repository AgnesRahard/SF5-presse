<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Cahier;
use App\Entity\Article;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', null, [
                'required' => false,
                'empty_data' => 'Non renseigné',
            ])
            // ->add('date_parution')
            ->add('date_parution', DateType::class, [
                "widget" => "single_text",
                "html5" => false,
                "attr" => ["class" => "js-datepicker"],
                "format" => "dd-MM-yyyy",
                "placeholder" => [
                    "year" => "Année",
                    "month" => "Mois",
                    "day" => "Jour"
                ]
            ])
            ->add('cahier', EntityType::class, [
                'class' => Cahier::class,
                'expanded' => true,
                'multiple' => false
            ])
            ->add('page')
            ->add('tags', EntityType::class, [
                'label' => 'Mot clé',
                'class' => Tag::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.etiquette', 'ASC');
                },
                'choice_label' => 'etiquette',
                'multiple' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
