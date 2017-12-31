<?php declare(strict_types=1);

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

/**
 * Class ErrorController
 * @package App\Controller
 * @author Ondra Votava <me@ondravotava.cz>
 */
class ErrorController extends Controller
{
    /**
     * @param Request                   $request
     * @param FlattenException          $exception
     * @param DebugLoggerInterface|null $logger
     *
     * @return Response
     */
    public function show(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null): Response
    {
        $text = 'Something is wrong. Server not working';
        $title = 'Error';
        if (404 === (int)$exception->getStatusCode()) {
            $title = $text = 'Page not found';
        }
        if (403 === (int)$exception->getStatusCode()) {
            $title = $text = 'Access denied';
        }
      
        return $this->render(
            'error/error.html.twig',
            [
                'title' => $title,
                'text' => $text
            ]
        );
    }
}
