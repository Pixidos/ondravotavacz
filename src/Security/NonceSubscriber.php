<?php
/**
 * Created by PhpStorm.
 * User: ondra
 * Date: 03.01.18
 * Time: 22:28
 */

namespace App\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class NonceSubscriber
 * @package App\Security
 * @author Ondra Votava <me@ondravotava.cz>
 */
class NonceSubscriber implements EventSubscriberInterface
{
    /**
     * @var NonceGeneratorInterface
     */
    private $nonceGenerator;
    
    /**
     * NonceSubscriber constructor.
     *
     * @param NonceGeneratorInterface $nonceGenerator
     */
    public function __construct(NonceGeneratorInterface $nonceGenerator)
    {
        $this->nonceGenerator = $nonceGenerator;
    }
    
    /**
     * @param FilterResponseEvent $event
     */
    public function addCSPHeaderToResponse(FilterResponseEvent $event): void
    {
        // get the Response object from the event
        $response = $event->getResponse();
        
        // create a CSP rule, using the nonce generator service
        $nonce = $this->nonceGenerator->getNonce();
        $cspHeader = "default-src 'none'; ";
        // Images
        $cspHeader .= "img-src 'self' https://www.google-analytics.com https://www.gstatic.com;";
        // Connect
        $cspHeader .= "connect-src 'self' https://www.google-analytics.com; ";
        // Scripts
        $cspHeader .= sprintf("script-src 'strict-dynamic' 'nonce-%s' 'self' 'report-sample' https://www.googletagmanager.com https://www.google-analytics.com; ", $nonce);
        // Styles
        $cspHeader .= sprintf("style-src 'self' 'nonce-%s' https://fonts.googleapis.com 'report-sample'; ", $nonce);
        // Fonts
        $cspHeader .= "font-src 'self' https://fonts.googleapis.com https://fonts.gstatic.com; frame-ancestors 'none'; ";
        // Form
        $cspHeader .= "form-action 'self'; ";
        // Uri
        $cspHeader .= "base-uri 'none';report-uri https://738b3fb6c6a6dae7e767ff601d34b671.report-uri.io/r/default/csp/enforce;";
        // set CPS header on the response object
        $response->headers->set('Content-Security-Policy', $cspHeader);
        
        // add other headers -> @TODO: make configable
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Powered-By', 'Ondra Votava code');
        $response->headers->set('Vary', 'X-Requested-With');
    }
    
    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'addCSPHeaderToResponse',
        ];
    }
    
}
