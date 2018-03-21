<?php
/**
 */

namespace App\Controller;

use App\Form\Type\ChangeUserInfoType;
use App\Service\UserDataManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ChangeUserInfoController extends Controller
{
    /**
     * @Route("/mon_compte", name="user_info")
     * @Security("has_role('ROLE_USER')")
     */
    public function changeUserInfoAction(Request $request, UserDataManager $userDataManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $userEmail = $user->getEmail();

        $form = $this->createForm(ChangeUserInfoType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() )
        {
            if($passwordEncoder->isPasswordValid($user, $user->getOldPassword()))
            {
                $userDataManager->setEncodePasswordToUser('newPassword', $user);
                $userDataManager->toDatabase($user);
                $this->addFlash('success', 'Le mot de passe a bien été changé');

                return $this->redirectToRoute('homepage');
            }
            else{
                $this->addFlash('danger', 'Ancient mot de passe incorrect, veuillez réessayer');
                return $this->redirectToRoute('user_info');
            }
        }
        return $this->render('ChangeUserInfo/changeUserInfo.html.twig', [
            'form' =>$form->createView(),
            'user_email' => $userEmail
        ]);
    }
}
