<?php
/**
 * Created by PhpStorm.
 * User: ondra
 * Date: 03.01.18
 * Time: 22:13
 */

namespace App\Security;


class NonceGenerator implements NonceGeneratorInterface
{
    /**
     * @var string|null
     */
    private $nonce;
    
    /**
     * @return string
     */
    public function getNonce(): string
    {
        if ($this->nonce) {
            return $this->nonce;
        }
        $this->nonce = base64_encode(random_bytes(20));
    
        return $this->nonce;
    }
    
}
