<?php
/**
 * Created by PhpStorm.
 * User: ondra
 * Date: 03.01.18
 * Time: 22:13
 */

namespace App\Security;


interface NonceGeneratorInterface
{
    /**
     * @return string
     */
    public function getNonce(): string ;
    
}
