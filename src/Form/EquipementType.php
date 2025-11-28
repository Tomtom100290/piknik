<?php

namespace App\Form;

use App\Entity\Equipement;
use App\Enum\ValorisationEquipement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('valo', ChoiceType::class, [
                'choices' => ValorisationEquipement::cases(),
                'choice_label' => fn(ValorisationEquipement $v) => $v->getLabel(),
                'choice_value' => fn(?ValorisationEquipement $v) => $v?->value,
    ])
            ->add('date_creat', null, [
                'widget' => 'single_text',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Equipement::class,
        ]);
    }
}
