<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Project;
use App\Entity\SousArticle;
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
    /**
     * @Route("/project/page/{id}", name="project_page")
     */
    public function project(Project $project)
    {
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('article_page/project.html.twig', [
            'project' => $project,
            'categories'=>$categories
        ]);
    }
    /**
     * @Route("/sous/article/page/{id}", name="sous_article_page")
     */
    public function SousArticle(SousArticle $article)
    {
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('sous_article_page/sousArticle.html.twig', [
            'article' => $article,
            'categories'=>$categories
        ]);
    }
}
