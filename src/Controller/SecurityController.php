<?php
/**
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @Route("/connexion", name="connexion")
     */
    public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $authenticationError = $authenticationUtils->getLastAuthenticationError();

        $lastLogin = $authenticationUtils->getLastUsername();

        return $this->render('Security/login.html.twig', array(
            'last_login' => $lastLogin,
            'error' =>$authenticationError,
        ));

    }
}