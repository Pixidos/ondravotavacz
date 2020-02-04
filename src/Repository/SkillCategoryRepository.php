<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\SkillCategory;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SkillCategoryRepository
 * @package App\Repository
 * @author Ondra Votava <ondra@votava.dev>
 */
class SkillCategoryRepository
{
    /**
     * @var EntityManagerInterface entityManager
     */
    private $entityManager;

    /**
     * SkillCategoryRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array|SkillCategory[]
     */
    public function getAllWithSkills(): array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->from(SkillCategory::class, 'skill_category', 'skill_category.id')
           ->addSelect('skill_category')
           ->orderBy('skill_category.id', 'ASC');
        $categories = $qb->getQuery()->getResult();

        $ids = array_keys($categories);
        $this->entityManager
            ->createQueryBuilder()
            ->from(SkillCategory::class, 'skill_category')
            ->select('partial skill_category.{id}')
            ->leftJoin('skill_category.skills', 'skills')
            ->addSelect('skills')
            ->where('skill_category.id IN (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();

        return $categories;
    }
}
