<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class NosServiceController extends AbstractController
{
    /**
     * @Route("/nos/service", name="nos_service")
     */
    public function index()
    {
        $categories= $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('nos_service/index.html.twig', [
            'categories' => $categories,
        ]);
    }
}
