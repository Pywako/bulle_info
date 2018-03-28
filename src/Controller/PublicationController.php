<?php
/**
 */

namespace App\Controller;


use App\Entity\Resource;
use App\Entity\Subject;
use App\Form\Type\CategorySubjectType;
use App\Form\Type\CreateSubjectType;
use App\Form\Type\ResourceType;
use App\Form\Type\SelectSubjectType;
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
                $publicationManager->setInSession('categorys', $categorys);

                if (isset($_POST['create'])){
                    $this->redirectToRoute('publication_create_subject');
                }
                if (isset($_POST['select'])){
                    $this->redirectToRoute('publication_select_subject');
                }
            }
        } else {
            $this->addFlash('danger', 'Veuillez créer votre ressource');
            return $this->redirectToRoute('publication_step1');
        }
        return $this->render(
            'Publication/categoryChoice.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/publication/create", name="publication_create_subject")
     * @Security("has_role('ROLE_USER')")
     */
    public function CreateSubjectAction(Request $request, PublicationManager $publicationManager)
    {
        if ($publicationManager->getDataInSession('resource')) {
            if ($publicationManager->getDataInSession('categorys')) {
                $subject = new Subject();
                $form = $this->createForm(CreateSubjectType::class, $subject);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {

                    $publicationManager->hydrateSubject($subject);
                    $publicationManager->setInSession('subject', $subject);

                    $this->redirectToRoute('publication_publish');
                }
            } else {
                $this->addFlash('danger', 'Veuillez sélectionner une catégorie');
                return $this->redirectToRoute('publication_step2');
            }
        } else {
            $this->addFlash('danger', 'Veuillez créer votre ressource');
            return $this->redirectToRoute('publication_step1');
        }
        return $this->render(
            'Publication/createSubject.html.twig', array(
                'categorys' => $publicationManager->getDataInSession('categorys'),
                'form' => $form->createView()
        ));
    }

    /**
     * @Route("/publication/select", name="publication_select_subject")
     * @Security("has_role('ROLE_USER')")
     */
    public function SelectSubjectAction(Request $request, PublicationManager $publicationManager)
    {
        if ($publicationManager->getDataInSession('resource')) {
            if ($publicationManager->getDataInSession('categorys')) {
                $form = $this->createForm(SelectSubjectType::class);
                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $formData = $form->getData();
                    $subject = $formData['title'];

                    $publicationManager->setInSession('subject', $subject);
                    $this->redirectToRoute('publication_publish');
                }
            } else {
                $this->addFlash('danger', 'Veuillez sélectionner une catégorie');
                return $this->redirectToRoute('publication_step2');
            }
        } else {
            $this->addFlash('danger', 'Veuillez créer votre ressource');
            return $this->redirectToRoute('publication_step1');
        }
        return $this->render(
            'Publication/selectSubject.html.twig', array(
                'categorys' => $publicationManager->getDataInSession('categorys'),
                'form' => $form->createView()
        ));
    }

    /**
     *
     * @Route("/publication/publication", name="publication_publish")
     * @Security("has_role('ROLE_USER')")
     */
    Public
    function PublishAction(Request $request, SessionInterface $session, PublicationManager $publicationManager)
    {
        if ($publicationManager->getDataInSession('resource')) {
            if ($publicationManager->getDataInSession('categorys')) {
                if ($publicationManager->getDataInSession('subject')) {
                    $categorys = $publicationManager->getDataInSession('categorys');
                    $subject = $publicationManager->getDataInSession('subject');
                    $resource = $publicationManager->getDataInSession('resource');

                    if ($request->isMethod('POST')) {

                        $publicationManager->prepareEntitiesToPublish($resource, $subject, $categorys);
                        $publicationManager->pushEntitiesToDatabase($resource, $subject, $categorys);

                        $session->remove('resource');

                        $this->addFlash('success', 'Votre ressource a été ajouté avec succès ! ');
                        return $this->redirectToRoute('homepage');
                    }
                } else {
                    $this->addFlash('danger', 'Veuillez créer ou sélectionner un sujet');
                    return $this->redirectToRoute('publication_step2');
                }
            } else {
                $this->addFlash('danger', 'Veuillez sélectionner une catégorie');
                return $this->redirectToRoute('publication_step2');
            }
        } else {
            $this->addFlash('danger', 'Veuillez créer votre ressource');
            return $this->redirectToRoute('publication_step1');
        }

        return $this->render(
            'Publication/publish.html.twig', [
                'categorys' => $categorys,
                'subject' => $subject,
                'resource' => $resource
            ]
        );
    }
}
