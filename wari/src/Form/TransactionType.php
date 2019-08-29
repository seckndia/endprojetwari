<?php

namespace App\Form;

use App\Entity\Transaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomEnvoi')
            ->add('prenomEvoie')
            ->add('cniEnvoie')
            ->add('montantEnvoi')
            // ->add('dateEnvoie')
            ->add('codeEnvoie')
            ->add('cniRetrait')
            ->add('montantRetrait')
            // ->add('dateRetrait')
            ->add('telEnvoi')
            ->add('telRetrait')
            // ->add('commissionEtat')
            // ->add('commissionAdmin')
            // ->add('commissionRetrait')
            // ->add('commissionEnvoie')
            // ->add('status')
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
            'csrf_protection'=>false
        ]);
    }
}
