<?php
/**
 * Created by PhpStorm.
 * User: Ondra Votava
 * Date: 21.12.17
 * Time: 6:54
 */

namespace App\Admin\Field;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class DateType
 * @package App\Admin\Field
 * @author Ondra Votava <ondrej.votava@mediafactory.cz>
 */

class DateType extends \Symfony\Component\Form\Extension\Core\Type\DateType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        // Set the defaults from the DateTimeType we're extending from
        parent::configureOptions($resolver);
        
        // Override: Go back 20 years and add 20 years
        $resolver->setDefault('years', range(date('Y') - 20, date('Y') + 3));
        
    }
}
