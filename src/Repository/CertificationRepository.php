<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Certification;
use Doctrine\ORM\EntityManagerInterface;

class CertificationRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * CertificationRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $sortDirection
     *
     * @return array<Certification>
     */
    public function getAll($sortDirection = 'DESC'): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->from(Certification::class, 'certification', 'certification.id')
            ->select('certification')
            ->addOrderBy('certification.when', $sortDirection)
            ->getQuery()
            ->getResult();
    }
}
