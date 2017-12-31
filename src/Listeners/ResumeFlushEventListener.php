<?php declare(strict_types=1);

namespace App\Listeners;


use App\Configs\PdfConfig;
use App\Data\Contact;
use App\Entity;
use App\Repository;
use App\Service\Resume;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Knp\Snappy\Pdf;
use Psr\Log\LoggerInterface;
use Twig\Environment;

/**
 * Class ResumeFlushEventListener
 * @package App\Subscribers
 * @author Ondra Votava <me@ondravotava.cz>
 */
class ResumeFlushEventListener
{
    /**
     * @var bool
     */
    private $rebuildResume = false;
    /**
     * @var Resume
     */
    private $resume;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var PdfConfig
     */
    private $config;
    /**
     * @var Pdf
     */
    private $pdf;
    /**
     * @var Contact
     */
    private $contact;
    /**
     * @var Environment
     */
    private $twig;
    
    /**
     * ResumeFlushEventListener constructor.
     *
     * @param LoggerInterface $logger
     * @param PdfConfig       $config
     * @param Pdf             $pdf
     * @param Contact         $contact
     * @param Environment     $twig
     */
    public function __construct(
        LoggerInterface $logger,
        PdfConfig $config,
        Pdf $pdf,
        Contact $contact,
        Environment $twig
    ) {
        $this->logger = $logger;
        $this->config = $config;
        $this->pdf = $pdf;
        $this->contact = $contact;
        $this->twig = $twig;
    }
    
    /**
     * @param Resume $resume
     */
    public function setResume(Resume $resume): void
    {
        $this->resume = $resume;
    }
    
    
    /**
     * @param OnFlushEventArgs $eventArgs
     */
    public function onFlush(OnFlushEventArgs $eventArgs): void
    {
        $uow = $eventArgs->getEntityManager()->getUnitOfWork();
        
        foreach ($uow->getScheduledEntityInsertions() as $entity) {
            $this->checkEntity($entity);
        }
        
        foreach ($uow->getScheduledEntityUpdates() as $entity) {
            $this->checkEntity($entity);
        }
        
        foreach ($uow->getScheduledEntityDeletions() as $entity) {
            $this->checkEntity($entity);
        }
        
    }
    
    /**
     * @param PostFlushEventArgs $eventArgs
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function postFlush(PostFlushEventArgs $eventArgs): void
    {
        if ($this->rebuildResume) {
            $entityManager = $eventArgs->getEntityManager();
            // Cant use serivce because circual reference
            $resume = new Resume(
                $entityManager,
                new Repository\ExperienceRespository($entityManager),
                new Repository\SkillCategoryRepository($entityManager),
                new Repository\SocialLinkRepository($entityManager),
                new Repository\CertificationRepository($entityManager),
                $this->contact,
                $this->twig,
                $this->pdf,
                $this->config
            );
            $resume->regenerate();
            $this->logger->info('CV was regenerate');
            $this->rebuildResume = false;
        }
    }
    
    /**
     * @param object $entity
     */
    private function checkEntity($entity): void
    {
        if (
            $entity instanceof Entity\Experience
            || $entity instanceof Entity\Skill
            || $entity instanceof Entity\SkillCategory
            || $entity instanceof Entity\Certification
            || $entity instanceof Entity\Snippet
            || $entity instanceof Entity\SocialLink
        ) {
            $this->rebuildResume = true;
        }
    }
}
