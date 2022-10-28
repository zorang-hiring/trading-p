<?php

namespace Form;

use App\Validator\ContainsValidCompanySymbol;
use Carbon\Carbon;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;

class MainFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('companySymbol', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new ContainsValidCompanySymbol()
                ]
            ])
            ->add('startDate', DateType::class, [
                'required' => true,
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'invalid_message' => 'Accepted date format is YYYY-MM-DD.',
                'constraints' => [
                    new NotBlank(),
                    new LessThanOrEqual([
                        'propertyPath' => 'parent.all[endDate].data',
                        'message' => 'Has to be less or equal then endDate.'
                    ]),
                    new LessThanOrEqual([
                        'value' => Carbon::now(),
                        'message' => 'Has to be less or equal then current date.'
                    ])
                ]
            ])
            ->add('endDate', DateType::class, [
                'required' => true,
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'invalid_message' => 'Accepted date format is YYYY-MM-DD.',
                'constraints' => [
                    new NotBlank(),
                    new GreaterThanOrEqual([
                        'propertyPath' => 'parent.all[startDate].data',
                        'message' => 'Has to be greater or equal then startDate.'
                    ]),
                    new LessThanOrEqual([
                        'value' => Carbon::now(),
                        'message' => 'Has to be less or equal then current date.'
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true
        ]);
    }

}