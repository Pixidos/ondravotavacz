<?php
/**
 * Created by PhpStorm.
 * User: Ondra Votava
 * Date: 19.12.17
 * Time: 7:22
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SkillCategory
 * @package App\Entity
 *
 * @ORM\Entity()
 * @ORM\Table(name="skill_categories")
 */
class SkillCategory
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
    private $category;
    
    /**
     * @ORM\OneToMany(targetEntity="Skill", mappedBy="category", cascade={"all"})
     * @var Skill[]|\Doctrine\Common\Collections\ArrayCollection
     */
    private $skills;
    
    /**
     * SkillCategory constructor.
     */
    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }
    
    /**
     * @return null|string
     */
    public function __toString(): ?string
    {
        return $this->category;
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
    public function getCategory(): ?string
    {
        return $this->category;
    }
    
    /**
     * @param string $category
     *
     * @return SkillCategory
     */
    public function setCategory(string $category): SkillCategory
    {
        $this->category = $category;
        
        return $this;
    }
    
    /**
     * @return Skill[]|ArrayCollection
     */
    public function getSkills()
    {
        return $this->skills;
    }
    
    /**
     * @param Skill $skill
     *
     * @return $this
     */
    public function addSkill(Skill $skill)
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
        }
        
        return $this;
    }
    
    /**
     * @param Skill $skill
     *
     * @return $this
     */
    public function removeSkill(Skill $skill)
    {
        if ($this->skills->contains($skill)) {
            $this->skills->removeElement($skill);
        }
        
        return $this;
    }
    
    
}
