<?php
/**
 * Created by PhpStorm.
 * User: Ondra Votava
 * Date: 19.12.17
 * Time: 7:17
 */

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Experience
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="experience")
 */
class Experience
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
    private $position;
    
    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    private $place;
    
    /**
     * @Assert\NotNull()
     * @ORM\Column(type="date", nullable=false)
     * @var DateTime
     */
    private $fromDate;
    
    /**
     * @ORM\Column(type="date", nullable=true)
     * @var DateTime|null
     */
    private $toDate;
    
    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text", nullable=false)
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
    public function getPosition(): ?string
    {
        return $this->position;
    }
    
    /**
     * @param string $position
     *
     * @return Experience
     */
    public function setPosition(string $position): Experience
    {
        $this->position = $position;
        
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getPlace(): ?string
    {
        return $this->place;
    }
    
    /**
     * @param string $place
     *
     * @return Experience
     */
    public function setPlace(string $place): Experience
    {
        $this->place = $place;
        
        return $this;
    }
    
    /**
     * @return DateTime|null
     */
    public function getFromDate(): ?DateTime
    {
        return $this->fromDate;
    }
    
    /**
     * @param DateTime $fromDate
     *
     * @return Experience
     */
    public function setFromDate(DateTime $fromDate): Experience
    {
        $this->fromDate = $fromDate;
        
        return $this;
    }
    
    /**
     * @return DateTime|null
     */
    public function getToDate(): ?DateTime
    {
        return $this->toDate;
    }
    
    /**
     * @param null|DateTime $toDate
     *
     * @return Experience
     */
    public function setToDate(?DateTime $toDate): Experience
    {
        $this->toDate = $toDate;
        
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
     * @return Experience
     */
    public function setDescription(string $description): Experience
    {
        $this->description = $description;
        
        return $this;
    }
    
    
}
