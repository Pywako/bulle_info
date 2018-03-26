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
            $publicationManager->hydrateResource($resource);
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
    public function CategoryChoiceAction(Request $request, PublicationManager $publicationManager)
    {
        $form = $this->createForm(CategorySubjectType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category_subject_data = $form->getData();

            $categorys = $category_subject_data['title_category'];

            if (!empty($category_subject_data['title_subject_text'])) {
                $subject = new Subject();
                $publicationManager->hydrateSubject($subject, $category_subject_data['title_subject_text']);
            } elseif (!empty($category_subject_data['title_subject'])) {
                $publicationManager->hydrateSubject($category_subject_data['title_subject_text'],
                    $category_subject_data['title_subject']->getTitle());
            }
            $resource = $publicationManager->getDataInSession('resource');
            $resource->setSubject($subject);

            $publicationManager->prepareToPublish($resource, $subject, $categorys );
            $publicationManager->toDatabase($resource);
            $publicationManager->toDatabase($subject);
            foreach ($categorys as $category)
            {
                $publicationManager->toDatabase($category);
            }

            return $this->redirectToRoute('publication_step3');
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
    Public function PublishAction(Request $request, SessionInterface $session, PublicationManager $publicationManager)
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
