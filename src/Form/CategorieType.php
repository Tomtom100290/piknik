<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Enum\VisualisationStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            /*->add('date_creat', null, [
                'widget' => 'single_text',
            ])*/
            ->add('statusVisu',  EnumType::class, [
                'class' => VisualisationStatus::class,
                'choice_label' => fn(VisualisationStatus $status) => $status->getLabel(),
                                            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
