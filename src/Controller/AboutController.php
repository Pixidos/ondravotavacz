<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\AboutMe;
use App\Service\ContactForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class AboutController
 * @package App\Controller
 * @author Ondra Votava <ondra@votava.dev>
 */
class AboutController extends AbstractController
{
    /**
     * @var AboutMe
     */
    private $aboutMe;
    /**
     * @var ContactForm
     */
    private $contactForm;

    /**
     * AboutController constructor.
     *
     * @param AboutMe     $aboutMe
     * @param ContactForm $contactForm
     */
    public function __construct(AboutMe $aboutMe, ContactForm $contactForm)
    {
        $this->aboutMe = $aboutMe;
        $this->contactForm = $contactForm;
    }

    /**
     * @Route("/", name="about")
     * @Route("/", name="homepage")
     * @param Request $request
     *
     * @return Response
     * @throws InvalidOptionsException
     */
    public function index(Request $request): Response
    {
        $data = $this->aboutMe->getData();
        $this->contactForm->create($this->generateUrl('about', [], UrlGeneratorInterface::ABSOLUTE_URL));
        if ($request->isMethod('POST')) {
            $send = $this->contactForm->handleRequest($request);
            if ($request->isXmlHttpRequest()) {
                if ($send) {
                    return new JsonResponse(['status' => 'success']);
                }

                return new JsonResponse([
                    'status' => 'fail',
                    'errors' => $this->contactForm->getErrors(),
                ], Response::HTTP_NOT_ACCEPTABLE);
            }
        }
        $data['form'] = $this->contactForm->getFromView();

        return $this->render('aboutme.html.twig', $data);
    }
}
