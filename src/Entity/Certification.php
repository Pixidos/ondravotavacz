<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Education
 * @package App\Entity
 * @author Ondra Votava <ondra@votava.dev>
 *
 * @ORM\Entity()
 * @ORM\Table(name="certification")
 */
class Certification
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $title;

    /**
     * @Assert\NotNull()
     * @ORM\Column(name="`when`", type="date", nullable=false)
     * @var DateTime
     */
    private $when;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @var string
     */
    private $description;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Certification
     */
    public function setTitle(string $title): Certification
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getWhen(): ?DateTime
    {
        return $this->when;
    }

    /**
     * @param DateTime $when
     *
     * @return Certification
     */
    public function setWhen(DateTime $when): Certification
    {
        $this->when = $when;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return Certification
     */
    public function setDescription(string $description): Certification
    {
        $this->description = $description;

        return $this;
    }
}
