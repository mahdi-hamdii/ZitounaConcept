<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Project;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FirstPageController extends AbstractController
{
    /**
     * @Route("/", name="first_page")
     */
    public function index()
    {
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $projects=$this->getDoctrine()->getRepository(Project::class)->findAll();
        return $this->render('first_page/index.html.twig', [
            'categories'=>$categories,
            'projects'=>$projects
        ]);
    }
}
