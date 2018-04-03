<?php
/**
 */

namespace App\Controller;


use App\Entity\Category;
use App\Entity\Resource;
use App\Entity\Subject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DisplayController extends Controller
{
    /**
     * @Route("/show/{page}", defaults={"page"=1}, name="show")
     */
    public function ShowAction(int $page, SessionInterface $session)
    {
        $categorys = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        $subjectsTotal = $subjects = $this->getDoctrine()
            ->getRepository(Subject::class)
            ->findAll();
        $subjects = $this->getDoctrine()
            ->getRepository(Subject::class)
            ->findSubjects($page, Subject::NUMBER_SUBJECT_DISPLAY_MAX);
        $session->set('categorys', $categorys);

        $pagination = [
            'page' =>$page,
            'route' => 'show',
            'page_count' =>ceil(count($subjectsTotal)/Subject::NUMBER_SUBJECT_DISPLAY_MAX),
            'route_params' => []
        ];

        return $this->render('Display/show.html.twig', [
            'categorys' => $categorys,
            'subjects' => $subjects,
            'path' => 'show',
            'subjectTotal' => $subjectsTotal,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/show/subject/{title}/{page}", defaults={"title" = 0, "page" = 1}, name="show_subject")
     */
    public function ShowSubjectAction( Category $category, int $page, SessionInterface $session )
    {
        $subjects = $category->getSubjects();

        $pagination = [
            'page' =>$page,
            'route' => 'show_subject',
            'page_count' =>ceil(count($subjects)/Subject::NUMBER_SUBJECT_DISPLAY_MAX),
            'route_params' => []
        ];

        return $this->render('Display/showSubject.html.twig', [
            'subjects' => $subjects,
            'categorys' => $session->get('categorys'),
            'current_category' => $category->getTitle(),
            'path' => 'show',
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/show/resource/{title}/{page}", defaults={"page"=1}, name="show_one_subject")
     */
    public function ShowOneSubjectAction(Subject $subject, int $page)
    {
        $resources = $subject->getResources();
        $pagination = [
            'page' =>$page,
            'route' => 'show_subject',
            'page_count' =>ceil(count($resources)/Resource::NUMBER_RESOURCE_DISPLAY_MAX),
            'route_params' => []
        ];

        return $this->render('Display/showOneSubject.html.twig', [
           'resources' => $resources,
            'path' => 'show',
            'subject' => $subject,
            'pagination' => $pagination
        ]);
    }
}