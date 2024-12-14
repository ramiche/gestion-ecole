<?php

namespace App\Form;

use App\Entity\Classes;
use App\Entity\Eleves;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ElevesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomEleve')
            ->add('prenomEleve')
            ->add('dateNaissance', null, [
                'widget' => 'single_text',
            ])
            ->add('classeEleve', EntityType::class, [
                'class' => Classes::class,
                'choice_label' => 'id',
            ])
            ->add('moyenne', NumberType::class, [
                'required' => true,
                'attr' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 0.1,
                ],
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Eleves::class,
        ]);
    }
}
