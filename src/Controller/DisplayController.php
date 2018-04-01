<?php
/**
 */

namespace App\Controller;


use App\Entity\Category;
use App\Entity\Subject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DisplayController extends Controller
{
    /**
     * @Route("/show", name="show")
     */
    public function ShowAction(SessionInterface $session)
    {
        $categorys = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        $subjects = $this->getDoctrine()
            ->getRepository(Subject::class)
            ->findAll();
        $session->set('categorys', $categorys);

        return $this->render('Display/show.html.twig', [
            'categorys' => $categorys,
            'subjects' => $subjects
        ]);
    }

    /**
     * @Route("/show/{title}", name="show_subject")
     */
    public function ShowSubjectAction(Category $category, SessionInterface $session )
    {
        $subjects = $category->getSubjects();

        return $this->render('Display/showSubject.html.twig', [
            'subjects' => $subjects,
            'categorys' => $session->get('categorys'),
            'current_category' => $category->getTitle()
        ]);
    }

}