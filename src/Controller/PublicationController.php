<?php
/**
 */

namespace App\Controller;


use App\Entity\Resource;
use App\Entity\Subject;
use App\Form\ResourceType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends Controller
{
    /**
     * @Route("/publier", name="publier")
     */
    public function publishAction(Request $request)
    {
        $resource = new Resource();
        $form = $this->createForm(ResourceType::class, $resource);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $task = $form->getData();

            $subject = new Subject();
            $now =new \dateTime();

            //Subject
            $formSubjectTitle = $task->getSubject()->getTitle();
            $subject->setTitle($formSubjectTitle);

            if(is_null($subject->getCreationDate()))
            {
                $subject->setCreationDate($now);
            }
            $subject->setUpdateDate($now);
            $task->setSubject($subject);

            //resource
            if(is_null($task->getCreationDate()))
            {
                $task->setCreationDate($now);
            }
            $task->setUpdateDate($now);
            $user = $this->getUser();
            $task->setUser($user);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }
        return $this->render(
            'Publication/publish.html.twig', array('form' => $form->createView())
        );
    }

}