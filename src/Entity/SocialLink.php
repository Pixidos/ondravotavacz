<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Social
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="social_links")
 */
class SocialLink
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
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $icon;

    /**
     * @Assert\NotBlank()
     * @Assert\Url()
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $link;

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
     * @return SocialLink
     */
    public function setTitle(string $title): SocialLink
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIcon(): ?string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     *
     * @return SocialLink
     */
    public function setIcon(string $icon): SocialLink
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return SocialLink
     */
    public function setLink(string $link): SocialLink
    {
        $this->link = $link;

        return $this;
    }
}
