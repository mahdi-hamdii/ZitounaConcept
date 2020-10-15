<?php

namespace App\Controller;

use App\Entity\CatalogArticle;
use App\Entity\Categorie;
use App\Entity\sousCategorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ThirdPageController extends AbstractController
{
    /**
     * @Route("/list/article/page/{id}", name="third_page")
     */
    public function index(sousCategorie $sousCategorie)
    {
        $articles=$sousCategorie->getArticles();
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $catalogue=$sousCategorie->getCatalogArticles();
        return $this->render('third_page/index.html.twig', [
            'articles' => $articles,
            'souscategorie'=>$sousCategorie,
            'categories'=>$categories,
            'catalogues'=>$catalogue
        ]);
    }
    /**
     * @Route("/list/sous/article/page/{id}", name="list_sous_article_page")
     */
    public function listSousArticle(CatalogArticle $catalogArticle)
    {
        $articles=$catalogArticle->getSousArticles();
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('sous_article_page/index.html.twig', [
            'articles' => $articles,
            'categories'=>$categories,
            'catalogue'=>$catalogArticle
        ]);
    }
}
