<?php
/**
 * Created by PhpStorm.
 * User: ondra
 * Date: 27.12.17
 * Time: 15:49
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @package App\Controller
 * @author Ondra Votava <me@ondravotava.cz>
 */
class SecurityController extends Controller
{
    
    /**
     * @Route("/login", name="login")
     * @param Request             $request
     * @param AuthenticationUtils $authUtils
     *
     * @return Response
     */
    public function login(Request $request, AuthenticationUtils $authUtils): Response
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();
        
        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();
        
        return $this->render('login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
    
    
}
