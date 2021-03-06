<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\SousArticle;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PromotionController extends AbstractController
{
    /**
     * @Route("/promotion", name="promotion")
     */
    public function index()
    {
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $articlePromotion=$this->getDoctrine()->getRepository(Article::class)->findPromotion();
        $sousArticlePromotion=$this->getDoctrine()->getRepository(SousArticle::class)->findPromotion();
        return $this->render('promotion/index.html.twig', [
            'categories' => $categories,
            'articles'=>$articlePromotion,
            'sousArticles'=>$sousArticlePromotion
        ]);
    }
}
