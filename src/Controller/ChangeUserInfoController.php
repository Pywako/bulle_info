<?php
/**
 */

namespace App\Controller;

use App\Form\Type\ChangeUserInfoType;
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
    public function changeUserInfoAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $userEmail = $user->getEmail();
        $form = $this->createForm(ChangeUserInfoType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() )
        {
            $oldPassword = $user->getOldPassword();
            if($passwordEncoder->isPasswordValid($user, $oldPassword))
            {
                $newPassword = $passwordEncoder->encodePassword($user, $user->getNewPassword());
                $user->setPassword($newPassword);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('sucess', 'Le mot de passe a bien été changé');

                return $this->redirectToRoute('homepage');
            }
            else{
                $this->addFlash('notice', 'Ancient mot de passe incorrect, veuillez réessayer');
                return $this->redirectToRoute('user_info');
            }
        }
        return $this->render('ChangeUserInfo/changeUserInfo.html.twig', [
            'form' =>$form->createView(),
            'user_email' => $userEmail
        ]);
    }

}