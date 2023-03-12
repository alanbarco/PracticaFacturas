<?php

namespace App\Form;

use App\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TecnicoTicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tipo', ChoiceType::class,[
                'required'=>true,
                'multiple'=>false,
                'choices'=> $options["arrayTipos"],
                'choice_value'=>'id_tipo',
                'choice_label'=>'descripcion',
                'mapped'=>false,
                'attr' => [
                    'class'=>'form-control',
                    'required'=>true                    
                ]
            ])
            ->add('horasInv', NumberType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
            'arrayTipos'=>array()
        ]);
    }
}
