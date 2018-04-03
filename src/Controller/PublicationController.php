<?php
/**
 */

namespace App\Controller;


use App\Entity\Resource;
use App\Entity\Subject;
use App\Form\Type\CategoryType;
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
     * @Route("/publication/ressource/{subject}", defaults={"subject"="nouveau"}, name="publication_step1")
     * @Security("has_role('ROLE_USER')")
     */
    public function ResourcePreparationAction(string $subject, Request $request, PublicationManager $publicationManager)
    {
        if (empty($publicationManager->getDataInSession('resource'))) {
            $resource = new Resource();
        } else {
            $resource = $publicationManager->getDataInSession('resource');
        }

        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $resource->setTitle(strtolower($resource->getTitle()));
            $resource->setTag(strtolower($resource->getTag()));

            if(isset($subject) && $subject != "nouveau") // Ajout d'une ressource dans un sujet
            {
                $subject_title = $subject;
                $subject_repository = $this->getDoctrine()->getRepository(Subject::class);

                if (!empty($subject_repository->findBy(['title' => $subject_title])) && $subject_repository->findBy(['title' => $subject_title]) != []) {
                    $subject_array = $this->getDoctrine()->getRepository(Subject::class)
                        ->findBy(['title' => $subject_title]);
                    foreach ($subject_array as $subject){
                        $categorys = $subject->getCategorys();
                    }

                    $publicationManager->prepareEntitiesToPublish($resource, $subject);
                    $publicationManager->pushEntitiesToDatabase($resource, $subject, $categorys);
                    $this->addFlash('success', 'Votre ressource a été ajouté avec succès ! ');
                    return $this->redirectToRoute('homepage');
                }else{
                    $this->addFlash('danger', 'Ce sujet n\'existe pas ;)');
                    return $this->redirectToRoute('publication_step1');
                }
            }else{
                $publicationManager->setInSession('resource', $resource);
                return $this->redirectToRoute('publication_step2');
            }
        }
        return $this->render(
            'Publication/resourcePreparation.html.twig', array(
                'form' => $form->createView(),
                'path' => 'publication'
            )
        );
    }

    /**
     * @Route("/publication/sujet", name="publication_step2")
     * @Security("has_role('ROLE_USER')")
     */
    public function StoreAction(Request $request, SessionInterface $session, PublicationManager $publicationManager)
    {
        if (!empty($session->get('resource'))) {
            $subjectList = $this->getDoctrine()->getRepository(Subject::class)->findAll();
            $subject_title_List = [];
            foreach ($subjectList as $subject) {
                $subject_title_List[] = $subject->getTitle();
            }
            $form = $this->createForm(SelectSubjectType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $formData = $form->getData();

                $subject_title = strtolower($formData['subject_title']);
                $subject_repository = $this->getDoctrine()->getRepository(Subject::class);

                if (!empty($subject_repository->findBy(['title' => $subject_title])) && $subject_repository->findBy(['title' => $subject_title]) != []) {
                    $resource = $publicationManager->getDataInSession('resource');

                    $subject_array = $this->getDoctrine()->getRepository(Subject::class)
                        ->findBy(['title' => $subject_title]);
                    foreach ($subject_array as $subject){
                        $categorys = $subject->getCategorys();
                    }

                    $publicationManager->prepareEntitiesToPublish($resource, $subject);
                    $publicationManager->pushEntitiesToDatabase($resource, $subject, $categorys);

                    $session->remove('resource');
                    $session->remove('categorys');
                    $session->remove('subject_title');

                    $this->addFlash('success', 'Votre ressource a été ajouté avec succès ! ');
                    return $this->redirectToRoute('homepage');
                } else {
                    $publicationManager->setInSession('subject_title', $subject_title);
                    return $this->redirectToRoute('publication_step3');
                }
            }
        } else {
            $this->addFlash('danger', 'Veuillez créer votre ressource');
            return $this->redirectToRoute('publication_step1');
        }
        return $this->render(
            'Publication/store.html.twig', array(
            'form' => $form->createView(),
            'subjectList' => $subject_title_List,
            'path' => 'publication'
        ));
    }

    /**
     * @Route("/publication/categorie", name="publication_step3")
     * @Security("has_role('ROLE_USER')")
     */
    public function CreateSubjectAction(Request $request, SessionInterface $session, PublicationManager $publicationManager)
    {
        if ($publicationManager->getDataInSession('resource')) {
            $resource = $publicationManager->getDataInSession('resource');
            $subject_title = $publicationManager->getDataInSession('subject_title');

            $form = $this->createForm(CategoryType::class);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $categorys = $data['title'];
                $subject = new Subject;

                $subject->setTitle($subject_title);
                $publicationManager->prepareEntitiesToPublish($resource, $subject, $categorys);
                $publicationManager->pushEntitiesToDatabase($resource, $subject, $categorys);
                $session->remove('resource');

                $this->addFlash('success', 'Votre ressource a été ajouté avec succès ! ');
                return $this->redirectToRoute('homepage');
            }
        } else {
            $this->addFlash('danger', 'Veuillez créer votre ressource');
            return $this->redirectToRoute('publication_step1');
        }
        return $this->render(
            'Publication/createSubject.html.twig', array(
            'form' => $form->createView(),
            'path' => 'publication'
        ));
    }
}
