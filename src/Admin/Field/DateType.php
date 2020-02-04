<?php

declare(strict_types=1);

namespace App\Admin\Field;

use Symfony\Component\Form\Extension\Core\Type\DateType as BaseDateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DateType
 * @package App\Admin\Field
 * @author  Ondra Votava <ondra@votava.dev>
 */
class DateType extends BaseDateType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        // Set the defaults from the DateTimeType we're extending from
        parent::configureOptions($resolver);

        // Override: Go back 20 years and add 20 years
        $resolver->setDefault('years', range((int)date('Y') - 20, (int)date('Y') + 3));
    }
}
