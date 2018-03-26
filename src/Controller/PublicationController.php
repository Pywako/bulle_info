<?php
/**
 */

namespace App\Controller;


use App\Entity\Resource;
use App\Entity\Subject;
use App\Form\Type\CategorySubjectType;
use App\Form\Type\ResourceType;
use App\Service\PublicationManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends Controller
{
    /**
     * @Route("/publication/1", name="publication_step1")
     * @Security("has_role('ROLE_USER')")
     */
    public function ResourcePreparationAction(Request $request, PublicationManager $publicationManager)
    {
        if (empty($publicationManager->getDataInSession('resource'))) {
            $resource = new Resource();
        } else {
            $resource = $publicationManager->getDataInSession('resource');
        }

        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $publicationManager->setInSession('resource', $resource);
            return $this->redirectToRoute('publication_step2');
        }
        return $this->render(
            'Publication/resourcePreparation.html.twig', array('form' => $form->createView())
        );
    }

    /**
     * @Route("/publication/2", name="publication_step2")
     * @Security("has_role('ROLE_USER')")
     */
    public function CategoryChoiceAction(Request $request, SessionInterface $session, PublicationManager $publicationManager)
    {
        if (!empty($session->get('resource'))) {
            $form = $this->createForm(CategorySubjectType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $formData = $form->getData();

                $categorys = $formData['title_category'];
                if (!empty($formData['title_subject_text'])) {
                    $subject = new Subject();
                    $publicationManager->hydrateSubject($subject, $formData['title_subject_text']);
                } elseif (!empty($formData['title_subject'])) {
                    $subject = $formData['title_subject'];
                    $publicationManager->hydrateSubject($subject, $formData['title_subject']->getTitle());
                } else {
                    $this->addFlash('warning', 'Veuillez choisir ou entrer un sujet');
                    return $this->redirectToRoute('publication_step2');
                }
                $resource = $publicationManager->getDataInSession('resource');

                $publicationManager->prepareEntitiesToPublish($resource, $subject, $categorys);
                $publicationManager->pushEntitiesToDatabase($resource, $subject, $categorys);

                $session->remove('resource');

                $this->addFlash('success', 'Votre ressource a été ajouté avec succès ! ');
                return $this->redirectToRoute('homepage');
            }
        } else {
            $this->addFlash('danger', 'Veuillez entrer votre ressource en premier ;) ');
            return $this->redirectToRoute('publication_step1');
        }
        return $this->render(
            'Publication/categoryChoice.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     *
     * @Route("/publication/3", name="publication_step3")
     * @Security("has_role('ROLE_USER')")
     */
    Public
    function PublishAction(Request $request, SessionInterface $session, PublicationManager $publicationManager)
    {
        $category = $publicationManager->getDataInSession('category');
        $subject = $publicationManager->getDataInSession('subject');
        $resource = $publicationManager->getDataInSession('resource');

        return $this->render(
            'Publication/publish.html.twig', [
                'category' => $category,
                'subject' => $subject,
                'resource' => $resource
            ]
        );
    }
}
