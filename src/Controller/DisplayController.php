<?php
/**
 */

namespace App\Controller;


use App\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class DisplayController extends Controller
{
    /**
     * @Route("/show", name="show")
     * @Security("has_role('ROLE_USER')")
     */
    public function ShowAction()
    {
        $categorys = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
        return $this->render('Display/show.html.twig', [
            'categorys' => $categorys,
        ]);
    }

    /**
     * @Route("/show/", name="show_sujet")
     */
    public function ShowSubjectAction()
    {
        $subjects = "";
        return $this->render('Display/_showSubject.html.twig', [
            'subjects' => $subjects,
        ]);
    }

}