<?php
/**
 */

namespace App\Controller;


use App\Entity\User;
use App\Form\Type\LoginFormType;
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
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        $user = new User();
        $user->setUsername($lastUsername);
        $form = $this->createForm(LoginFormType::class, $user);

        return $this->render('Security/login.html.twig', array(
            'form' => $form->createView(),
            'error' => 'le nom d\'utilisateur ou mot de passe est incorrect, veuillez réessayer',
            'path' => 'login'
        ));
    }

    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function logoutAction()
    {
        throw new \Exception('La déconnexion a un soucis');
    }
}
