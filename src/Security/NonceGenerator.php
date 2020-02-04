<?php

declare(strict_types=1);

namespace App\Security;

use Exception;

class NonceGenerator implements NonceGeneratorInterface
{
    /**
     * @var string|null
     */
    private $nonce;

    /**
     * @return string
     * @throws Exception
     */
    public function getNonce(): string
    {
        if ($this->nonce !== null) {
            return $this->nonce;
        }
        $this->nonce = base64_encode(random_bytes(20));

        return $this->nonce;
    }
}
