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
        $cspHeader =  sprintf("default-src 'none'; img-src 'self' https://www.google-analytics.com; script-src 'strict-dynamic' 'nonce-%s' 'self' 'report-sample' https://www.google-analytics.com; style-src 'self' https://fonts.googleapis.com 'report-sample'; font-src 'self' https://fonts.googleapis.com https://fonts.gstatic.com; frame-ancestors 'none'; form-action 'self'; base-uri 'none';report-uri https://738b3fb6c6a6dae7e767ff601d34b671.report-uri.io/r/default/csp/enforce;", $nonce);
        // set CPS header on the response object
        $response->headers->set('Content-Security-Policy', $cspHeader);
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
