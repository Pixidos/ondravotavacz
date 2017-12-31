<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Skill
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="skills")
 */
class Skill
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
    private $skill;
    
    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="integer", nullable=false)
     * @var integer
     */
    private $points;
    
    /**
     * @ORM\ManyToOne(targetEntity="SkillCategory", inversedBy="skills", cascade={"all"})
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @var SkillCategory
     */
    private $category;
    
    public function __toString(): ?string
    {
        return $this->skill;
    }
    
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
    public function getSkill(): ?string
    {
        return $this->skill;
    }
    
    /**
     * @param string $skill
     *
     * @return Skill
     */
    public function setSkill(string $skill): Skill
    {
        $this->skill = $skill;
        
        return $this;
    }
    
    /**
     * @return int|null
     */
    public function getPoints(): ?int
    {
        return $this->points;
    }
    
    /**
     * @param int $points
     *
     * @return Skill
     */
    public function setPoints(int $points): Skill
    {
        $this->points = $points;
        
        return $this;
    }
    
    /**
     * @return SkillCategory|null
     */
    public function getCategory(): ?SkillCategory
    {
        return $this->category;
    }
    
    /**
     * @param SkillCategory $category
     *
     * @return Skill
     */
    public function setCategory(SkillCategory $category): Skill
    {
        $this->category = $category;
        
        return $this;
    }
    
    
}
