<?php

namespace App\Form;

use App\Entity\Equipement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipementFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('equipements', EntityType::class, [
                'class' => Equipement::class,
                'choice_label' => 'nom',       // adapter si le champ s’appelle autrement
                'multiple' => true,
                'expanded' => true,            // affiche en checkbox
                'required' => false,
                'label' => 'Filtrer par équipements',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
        ]);
    }
}
