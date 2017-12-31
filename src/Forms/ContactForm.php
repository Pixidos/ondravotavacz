<?php declare(strict_types=1);

namespace App\Forms;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ContactForm
 * @package App\Forms
 * @author Ondra Votava <me@ondravotava.cz>
 */
class ContactForm extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     *
     * @throws \Symfony\Component\Validator\Exception\MissingOptionsException
     * @throws \Symfony\Component\Validator\Exception\InvalidOptionsException
     * @throws \Symfony\Component\Validator\Exception\ConstraintDefinitionException
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name', TextType::class, [
                    'constraints' => [
                        new NotBlank(['message' => 'Please provide your name']),
                    ],
                ]
            )
            ->add(
                'subject', TextType::class, [
                    'constraints' => [
                        new NotBlank(['message' => 'Please give a Subject']),
                    ],
                ]
            )
            ->add(
                'email', EmailType::class, [
                    'constraints' => [
                        new NotBlank(['message' => 'Please provide a valid email',]),
                        new Email(['message' => 'Your email doesn\'t seems to be valid', 'checkMX' =>true]),
                    ],
                ]
            )
            ->add(
                'message', TextareaType::class, [
                    'constraints' => [
                        new NotBlank(['message' => 'Please provide a message here']),
                    ],
                ]
            );
    }
    
    /**
     * @param OptionsResolver $resolver
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'error_bubbling' => true,
                'attr' => ['id' => 'contact-form']
            ]
        );
    }
    
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'contact_form';
    }
}
