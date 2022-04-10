<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\AbTest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AbTestType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('patient', TextType::class, [
            'required' => true,
            'mapped' => true,
        ]);
        $builder->add('patientIdentifier', TextType::class, [
            'required' => true,
            'mapped' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AbTest::class,
        ]);
    }
}
