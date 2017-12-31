<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Experience;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class ExperienceRespository
 * @package App\Repository
 * @author Ondra Votava <me@ondravotava.cz>
 */

class ExperienceRespository
{
    /**
     * @var EntityManagerInterface entityManager
     */
    private $entityManager;
    
    /**
     * ExperienceRespository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * @return array|Experience[]
     */
    public function getAll(): array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->from(Experience::class, 'experience', 'experience.id')
           ->select('experience')
           ->addSelect('CASE WHEN experience.toDate IS NULL THEN 1 ELSE 0 END AS HIDDEN toDateSort')
           ->addOrderBy('toDateSort', 'DESC')
           ->addOrderBy('experience.toDate', 'DESC')
           ->addOrderBy('experience.fromDate', 'DESC');
        
        return $qb->getQuery()->getResult();
    }
}
