<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\Resume;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Twig_Error_Loader;
use Twig_Error_Runtime;
use Twig_Error_Syntax as Twig_Error_SyntaxAlias;

/**
 * Class AboutController
 * @package App\Controller
 * @author Ondra Votava <ondra@votava.dev>
 */
class DownloadResumeController extends Controller
{

    /**
     * @var Resume
     */
    private $resume;

    /**
     * AboutController constructor.
     *
     * @param Resume $resume
     */
    public function __construct(Resume $resume)
    {

        $this->resume = $resume;
    }

    /**
     * @Route("/download/resume", name="download_resume")
     * @param Request $request
     *
     * @return PdfResponse
     */
    public function index(Request $request): PdfResponse
    {
        return new PdfResponse($this->resume->getFileContent($request), 'ondravotava_cv.pdf');
    }
}
