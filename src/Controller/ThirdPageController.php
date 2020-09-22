<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\sousCategorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ThirdPageController extends AbstractController
{
    /**
     * @Route("/third/page/{id}", name="third_page")
     */
    public function index(sousCategorie $sousCategorie)
    {
        $articles=$sousCategorie->getArticles();
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('third_page/index.html.twig', [
            'articles' => $articles,
            'souscategorie'=>$sousCategorie,
            'categories'=>$categories
        ]);
    }
}
