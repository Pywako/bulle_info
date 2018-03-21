<?php
/**
 */

namespace App\Controller;


use App\Entity\Resource;
use App\Form\Type\ResourceType;
use App\Service\PublicationManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends Controller
{
    /**
     * @Route("/publier", name="publier")
     * @Security("has_role('ROLE_USER')")
     */
    public function publishAction(Request $request, PublicationManager $publicationManager)
    {
        $resource = new Resource();
        $form = $this->createForm(ResourceType::class, $resource);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $publicationManager->prepareResourceToPublish($resource);
            $publicationManager->toDatabase($resource);
            $this->addFlash('success', 'Ressource Publiée !');

            return $this->redirectToRoute('homepage');
        }
        return $this->render(
            'Publication/publish.html.twig', array('form' => $form->createView())
        );
    }

}