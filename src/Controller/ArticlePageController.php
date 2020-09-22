<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticlePageController extends AbstractController
{
    /**
     * @Route("/article/page/{id}", name="article_page")
     */
    public function index(Article $article)
    {
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('article_page/index.html.twig', [
            'article' => $article,
            'categories'=>$categories
        ]);
    }
}
