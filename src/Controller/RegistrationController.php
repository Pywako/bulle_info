<?php
/**
 */

namespace App\Controller;



use App\Form\Type\UserType;
use App\Service\UserDataManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends Controller
{
    /**
     * @Route("/inscription", name="user_registration")
     */
    public function registerAction(Request $request, UserDataManager $userDataManager)
    {
        $user = $userDataManager->createUser();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $userDataManager->hydrateforRegistration($user);
            $userDataManager->toDatabase($user);
            $this->addFlash('success', 'Enregistrement effectué, vous pouvez maintenant vous connecter');

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'Registration/register.html.twig', array(
                'form' => $form->createView(),
                'path' => 'registration'
            )
        );
    }
}