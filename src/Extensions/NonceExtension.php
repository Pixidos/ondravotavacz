<?php

declare(strict_types=1);

namespace App\Extensions;

use App\Security\NonceGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class NonceExtension
 * @package App\Extensions
 * @author Ondra Votava <ondra@votava.dev>
 */
class NonceExtension extends AbstractExtension
{
    /**
     * @var NonceGeneratorInterface
     */
    private $nonceGenerator;

    /**
     * NonceExtension constructor.
     *
     * @param NonceGeneratorInterface $nonceGenerator
     */
    public function __construct(NonceGeneratorInterface $nonceGenerator)
    {
        $this->nonceGenerator = $nonceGenerator;
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('nonce', [$this, 'getNonce']),
        ];
    }

    /**
     * @return string
     */
    public function getNonce(): string
    {
        return $this->nonceGenerator->getNonce();
    }
}
