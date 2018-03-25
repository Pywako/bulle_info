<?php
/**
 */

namespace App\Controller;


use App\Entity\Resource;
use App\Form\Type\CategoryType;
use App\Form\Type\ResourceType;
use App\Form\Type\SubjectType;
use App\Service\PublicationManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends Controller
{
    /**
     * @Route("/publication_step1", name="publication_step1")
     * @Security("has_role('ROLE_USER')")
     */
    public function CategoryChoiceAction(Request $request, SessionInterface $session, PublicationManager $publicationManager)
    {
        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $categorys = $form->getData()->getTitle();
            $publicationManager->setInSession('category', $categorys);
            return $this->redirectToRoute('publication_step2');
        }
        return $this->render(
            'Publication/categoryChoice.html.twig', array('form' => $form->createView())
        );
    }

}
