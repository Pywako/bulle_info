<?php
/**
 */

namespace App\Controller;


use App\Entity\Category;
use App\Entity\Resource;
use App\Entity\Subject;
use App\Service\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DisplayController extends Controller
{
    /**
     * @Route("/exploration/{page}", defaults={"page"=1}, name="show")
     */
    public function ShowAction(int $page, SessionInterface $session, PaginationService $paginationService)
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

        $pagination = $paginationService->returnPaginationArray($page, 'show', $subjectsTotal, Subject::NUMBER_SUBJECT_DISPLAY_MAX);

        return $this->render('Display/show.html.twig', [
            'categorys' => $categorys,
            'subjects' => $subjects,
            'path' => 'show',
            'subjectTotal' => $subjectsTotal,
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/exploration/sujet/{title}/{page}", defaults={"title" = 0, "page" = 1}, name="show_subject")
     */
    public function ShowSubjectAction(Category $category, int $page, SessionInterface $session, PaginationService $paginationService)
    {
        $subjects = $this->getDoctrine()
            ->getRepository(Subject::class)
            ->findSubjectsByCategory($category->getTitle(), $page, Subject::NUMBER_SUBJECT_DISPLAY_MAX);
        $pagination = $paginationService->returnPaginationArray($page, 'show_subject', $subjects, Subject::NUMBER_SUBJECT_DISPLAY_MAX);
        return $this->render('Display/showSubject.html.twig', [
            'subjects' => $subjects,
            'category_title' => $category->getTitle(),
            'categorys' => $session->get('categorys'),
            'current_category' => $category->getTitle(),
            'path' => 'show',
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/exploration/unSujet/{title}/{page}", defaults={"title"=0, "page"=1}, name="show_one_subject")
     */
    public function ShowOneSubjectAction(Subject $subject, int $page, PaginationService $paginationService)
    {
        $resources = $this->getDoctrine()
            ->getRepository(Resource::class)
            ->findResourcesBySubject($subject->getTitle(), $page, Resource::NUMBER_RESOURCE_DISPLAY_MAX);
        $pagination = $paginationService->returnPaginationArray($page, 'show_one_subject', $resources, Resource::NUMBER_RESOURCE_DISPLAY_MAX);

        return $this->render('Display/showOneSubject.html.twig', [
            'resources' => $resources,
            'subject_title' => $subject->getTitle(),
            'path' => 'show',
            'subject' => $subject,
            'pagination' => $pagination
        ]);
    }
}