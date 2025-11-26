<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Commune;
use App\Entity\Lieu;
use App\Enum\ValidationStatus;
use App\Enum\ValorisationEquipement;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File; // ⚠️ Import obligatoire

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('statut')
            ->add('date_creat', null, [
                'widget' => 'single_text',
            ])
            ->add('etat', EnumType::class, [
                'class' => ValidationStatus::class,
                'choice_label' => fn(ValidationStatus $status) => $status->getLabel(),
            ])
            ->add('valo', EnumType::class, [
                'class' => ValorisationEquipement::class,
                'choice_label' => fn(ValorisationEquipement $valo) => $valo->getLabel(),
            ])
            ->add('categorie_fk', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
            ])
            ->add('Arrondissement', EntityType::class, [
                'class' => Commune::class,
                'choice_label' => 'nom',
            ])
            ->add('imagesFiles', FileType::class, [
                'label' => 'Images',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'constraints' => [
                    new All([
                        'constraints' => [
                            new File([
                                'maxSize' => '5M',
                                'mimeTypes' => [
                                    'image/jpeg',
                                    'image/png',
                                    'image/webp',
                                ],
                            ])
                        ]
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
