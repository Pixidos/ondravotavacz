<?php

declare(strict_types=1);

namespace App\Security;

/**
 * Interface NonceGeneratorInterface
 * @package App\Security
 */
interface NonceGeneratorInterface
{
    /**
     * @return string
     */
    public function getNonce(): string;
}
