<?php

declare(strict_types=1);

namespace App\Extensions;

use App\Entity\Snippet;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class MarkdownExtension
 * @package App\Extensions
 * @author  Ondra Votava <ondrej.votava@mediafactory.cz>
 */
class SnippetsExtension extends AbstractExtension
{
    /**
     * @var EntityManagerInterface entityManager
     */
    private $entityManager;

    /**
     * SnippetsExtension constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array<TwigFilter>
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter(
                'snippet',
                [$this, 'getSnippet'],
                [
                             'is_safe' => ['html'],
                             'pre_escape' => 'html',
                         ]
            ),
        ];
    }

    /**
     * @param string $snippetId
     *
     * @return string
     */
    public function getSnippet(string $snippetId): string
    {
        /** @var Snippet $snippet */
        try {
            $snippet = $this->entityManager
                ->createQueryBuilder()
                ->select('snippet')
                ->from(Snippet::class, 'snippet', 'snippet.snippetId')
                ->where('snippet.snippetId = :snippetId')
                ->setParameter('snippetId', strtolower($snippetId))
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return ''; //TODO: need log this situation
        }

        if ($snippet === null) {
            return ''; //TODO: need log this situation
        }

        return $snippet->getText();
    }
}
