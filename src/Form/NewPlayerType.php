<?php

namespace App\Form;

use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NewPlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Survivor',
            ])
            // ->add('health')
            // ->add('maxHealth')
            // ->add('weaponCondition')
            // ->add('armorCondition')
            // ->add('medicineOneUnits')
            // ->add('medicineTwoUnits')
            // ->add('level')
            // ->add('moves')
            // ->add('weapon')
            // ->add('armor')
            // ->add('medicineOne')
            // ->add('medicineTwo')
            ->add('escape', SubmitType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
