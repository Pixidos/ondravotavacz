<?php declare(strict_types=1);

namespace App\Service;

use App\Data\Contact;
use App\Forms\ContactForm;
use App\Repository\CertificationRepository;
use App\Repository\ExperienceRespository;
use App\Repository\SkillCategoryRepository;
use App\Repository\SocialLinkRepository;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Class AboutMe
 * @package App\Service
 * @author Ondra Votava <me@ondravotava.cz>
 */
class AboutMe
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
     * @var SocialLinkRepository
     */
    private $linkRepository;
    /**
     * @var Contact
     */
    private $contact;
    /**
     * @var CertificationRepository
     */
    private $certificationRepository;
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    
    /**
     * AboutMe constructor.
     *
     * @param ExperienceRespository   $experienceRespository
     * @param SkillCategoryRepository $categoryRepository
     * @param SocialLinkRepository    $linkRepository
     * @param Contact                 $contact
     * @param CertificationRepository $certificationRepository
     * @param FormFactoryInterface    $formFactory
     */
    public function __construct(
        ExperienceRespository $experienceRespository,
        SkillCategoryRepository $categoryRepository,
        SocialLinkRepository $linkRepository,
        Contact $contact,
        CertificationRepository $certificationRepository,
        FormFactoryInterface $formFactory
    ) {
        $this->experienceRespository = $experienceRespository;
        $this->categoryRepository = $categoryRepository;
        $this->linkRepository = $linkRepository;
        $this->contact = $contact;
        $this->certificationRepository = $certificationRepository;
        $this->formFactory = $formFactory;
    }
    
    /**
     * @return array
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    public function getData(): array
    {
        return [
            'experiences' => $this->experienceRespository->getAll(),
            'skillCategories' => $this->categoryRepository->getAllWithSkills(),
            'socialLinks' => $this->linkRepository->getAll(),
            'contact' => $this->contact,
            'certifications' => $this->certificationRepository->getAll(),
            'form' => $this->creteContactFrom()->createView(),
        ];
    }
    
    /**
     * @return \Symfony\Component\Form\FormInterface
     * @throws \Symfony\Component\OptionsResolver\Exception\InvalidOptionsException
     */
    private function creteContactFrom(): \Symfony\Component\Form\FormInterface
    {
        return $this->formFactory->create(
            ContactForm::class, null, [
                'method' => 'post',
                'action' => '/',
            ]
        );
    }
    
}
