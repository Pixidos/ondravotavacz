<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\SocialLink;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SocialLinkRepository
 * @package App\Repository
 * @author Ondra Votava <me@ondravotava.cz>
 */
class SocialLinkRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    /**
     * SocialLinkRepository constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * @return SocialLink[]
     */
    public function getAll(): array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->from(SocialLink::class, 'social_link', 'social_link.id')
            ->addSelect('social_link')
            ->getQuery()
            ->getResult();
    }
}
