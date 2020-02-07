<?php

declare(strict_types=1);

namespace App\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class NonceSubscriber
 * @package App\Security
 * @author  Ondra Votava <ondra@votava.dev>
 */
class HeaderSubscriber implements EventSubscriberInterface
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
     * @param ResponseEvent $event
     * @return void
     */
    public function addCSPHeaderToResponse(ResponseEvent $event): void
    {
        // get the Response object from the event
        $response = $event->getResponse();

        // create a CSP rule, using the nonce generator service
        $nonce = $this->nonceGenerator->getNonce();
        $cspHeader = "default-src 'none'; ";
        // Images
        $cspHeader .= "img-src 'self' data: https://www.google-analytics.com https://www.gstatic.com;";
        // Connect
        $cspHeader .= "connect-src 'self' https://www.google-analytics.com; ";
        // Scripts
        $cspHeader .= sprintf(
            "script-src 'strict-dynamic' "
            . "'nonce-%s' 'self' "
            . "'report-sample' https://www.googletagmanager.com https://www.google-analytics.com; ",
            $nonce
        );
        // Styles
        $cspHeader .= sprintf("style-src 'self' 'nonce-%s' https://fonts.googleapis.com 'report-sample'; ", $nonce);
        // Fonts
        $cspHeader .= "font-src 'self' https://fonts.googleapis.com https://fonts.gstatic.com; frame-ancestors 'none';";
        // Form
        $cspHeader .= "form-action 'self'; ";
        // Uri
        $cspHeader .= "base-uri 'none';"
            . 'report-uri https://votava.report-uri.com/r/d/csp/enforce;';
        // set CPS header on the response object
        $response->headers->set('Content-Security-Policy', $cspHeader);
        $response->headers->set(
            'Feature-Policy',
            "vibrate 'self'; usermedia *; sync-xhr 'self' https://ondra.votava.it"
        );
        // add other headers -> @TODO: make configable
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Powered-By', 'Ondra Votava code');
        $response->headers->set('Vary', 'X-Requested-With');
        $response->headers->set(
            'Report-To',
            '{"group":"default","max_age":31536000,"endpoints":[{"url":"https://votava.report-uri.com/a/d/g"}],"include_subdomains":true}' //phpcs:ignore
        );
        $response->headers->set(
            'NEL',
            '{"report_to":"default","max_age":31536000,"include_subdomains":true}'
        );
    }

    /**
     * @return array<string,string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'addCSPHeaderToResponse',
        ];
    }
}
