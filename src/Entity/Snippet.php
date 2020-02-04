<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Snippet
 * @package App\Entity
 * @author Ondra Votava ja@ondravotava.cz>
 *
 * @ORM\Entity()
 * @ORM\Table(name="snippets")
 */
class Snippet
{
    /**
     * @Assert\NotBlank()
     * @ORM\Id
     * @ORM\Column(type="string", nullable=false, unique=true)
     * @var string
     */
    private $snippetId;

    /**
     * @ORM\Column(type="text", nullable=false)
     * @var string
     */
    private $text;

    /**
     * @return string|null
     */
    public function getSnippetId(): ?string
    {
        return $this->snippetId;
    }

    /**
     * @param string $snippetId
     *
     * @return Snippet
     */
    public function setSnippetId(string $snippetId): Snippet
    {
        $this->snippetId = $snippetId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return Snippet
     */
    public function setText(string $text): Snippet
    {
        $this->text = $text;

        return $this;
    }
}
