<?php
/**
 */

namespace App\Controller;




use App\Entity\User;
use App\Form\Type\ChangePasswordType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ChangePasswordController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("\modifier_mot_de_passe", name="change_password")
     * @Security("has_role('ROLE_USER')")
     */
    public function changePasswordAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new ChangePasswordType(), $user);
        $form->handleRequest($request);

        if($form->isValid()) {
            $user->setPlainPassword($user->getNewPassword());

            $manager = $this->getDoctrine()->getManager();
            $manager->flush();
            $this->addFlash('sucess', 'Le mot de passe a bien été changé');

            return $this->redirectToRoute('homepage');
        }
        return $this->render('ChangePassword/changePassword.html.twig', [
            'form' =>$form->createView()
        ]);
    }

}