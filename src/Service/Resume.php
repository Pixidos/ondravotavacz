<?php

declare(strict_types=1);

namespace App\Service;

use App\Configs\PdfConfig;
use App\Data\Contact;
use App\Entity\ResumeDownload;
use App\Exceptions\RuntimeException;
use App\Repository\CertificationRepository;
use App\Repository\ExperienceRespository;
use App\Repository\SkillCategoryRepository;
use App\Repository\SocialLinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class Resume
 * @package App\Service
 * @author  Ondra Votava <ondra@votava.dev>
 */
class Resume
{
    /**
     * @var ExperienceRespository
     */
    private $experienceRespository;
    /**
     * @var SkillCategoryRepository
     */
    private $categoryRepository;
    /**
     * @var Contact
     */
    private $contact;
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var Pdf
     */
    private $pdf;
    /**
     * @var SocialLinkRepository
     */
    private $linkRepository;
    /**
     * @var CertificationRepository
     */
    private $certificationRepository;
    /**
     * @var PdfConfig
     */
    private $config;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * Resume constructor.
     *
     * @param EntityManagerInterface  $entityManager
     * @param ExperienceRespository   $experienceRespository
     * @param SkillCategoryRepository $categoryRepository
     * @param SocialLinkRepository    $linkRepository
     * @param CertificationRepository $certificationRepository
     * @param Contact                 $contact
     * @param Environment             $twig
     * @param Pdf                     $pdf
     * @param PdfConfig               $config
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ExperienceRespository $experienceRespository,
        SkillCategoryRepository $categoryRepository,
        SocialLinkRepository $linkRepository,
        CertificationRepository $certificationRepository,
        Contact $contact,
        Environment $twig,
        Pdf $pdf,
        PdfConfig $config
    ) {
        $this->entityManager = $entityManager;
        $this->experienceRespository = $experienceRespository;
        $this->categoryRepository = $categoryRepository;
        $this->contact = $contact;
        $this->twig = $twig;
        $this->pdf = $pdf;
        $this->linkRepository = $linkRepository;
        $this->certificationRepository = $certificationRepository;
        $this->config = $config;
    }


    /**
     * @return void
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function regenerate(): void
    {
        $html = $this->twig->render(
            'resume.html.twig',
            [
                'experiences' => $this->experienceRespository->getAll(),
                'skillCategories' => $this->categoryRepository->getAllWithSkills(),
                'socialLinks' => $this->linkRepository->getAll(),
                'contact' => $this->contact,
                'certifications' => $this->certificationRepository->getAll(),
            ]
        );

        $content = $this->pdf->getOutputFromHtml(
            $html,
            [
                'lowquality' => false,
                'viewport-size' => '1024x768',
                'page-size' => 'A4',
            ]
        );

        $file = fopen($this->config->getOutput(), 'wb');
        if ($file === false) {
            throw new RuntimeException(sprintf('Cant write to file: "%s"', $this->config->getOutput()));
        }

        fwrite($file, $content);
        fclose($file);
    }

    /**
     * @param Request $request
     *
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function getFileContent(Request $request): string
    {
        $path = $this->config->getOutput();
        if (!file_exists($path)) {
            $this->regenerate();
        }
        if (!file_exists($path) || !is_readable($path)) {
            throw new RuntimeException('Pdf with CV is not readable');
        }

        $ip = $request->getClientIp() ?? '0.0.0.0';
        $download = new ResumeDownload($ip);
        $this->entityManager->persist($download);
        $this->entityManager->flush();

        return (string)file_get_contents($path);
    }
}
