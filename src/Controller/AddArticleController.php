<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\sousCategorie;
use App\Entity\User;
use App\Form\ArticleType;
use App\Form\SousCategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AddArticleController extends AbstractController
{
    /**
     * @Route("/admin/add/article", name="add_article")
     */
    public function index(Request $request,SluggerInterface $slugger, EntityManagerInterface $manager )
    {
        $article= new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($images) {
                foreach ($images as $image){
                    $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();
                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        'assets/upload',
                        $newFilename
                    );
                } catch (FileException $e) {
                    echo $e;
                }
                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $article->addImage($newFilename);
            }
            }

            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('add_article');
        }

        return $this->render('add_article/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/article/list",name="articleList")
     */
    public function main()
    {
        $cats = $this->getDoctrine()->getRepository(sousCategorie::class)->findAll();
        return$this->render('add_article/listArticle.html.twig',[
            'sousCategories'=>$cats
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/articles",name="articles")
     */

    public function list(Request $request)
    {
        $start = $request->query->get("start");
        $length = $request->query->get("length");
        $draw = $request->query->get("draw");
        $search = $request->query->get("search");
        $order = $request->query->get('order');
        $filter= $request->query->get('filter');
        $cat = $filter['cat'];
        $cat=$this->getDoctrine()->getRepository(sousCategorie::class)->findOneBy(['nom'=>$cat]);
        $articles = $this->getDoctrine()->getRepository(Article::class)->findBySousCategorie($cat);
        $data = array();
        $result = array();
        $idx = 0;
        foreach ($articles as $article) {
            $operatorArray= array();
            $operatorArray[]= $article->getId();
            $operatorArray[]= $article->getSousCategorie()->getNom();
            $operatorArray[]= $article->getNom();
            $operatorArray[]= $article->getDimension();
            $operatorArray[]= $article->getRetour();
            $result[] = $operatorArray;
        };
        $count = count($this->getDoctrine()->getRepository(Article::class)->findAll());
        $data['draw'] = $draw;
        $data['recordsTotal'] = $count;
        $data['recordsFiltered'] = $count;
        $data['data'] = $result;
        return new JsonResponse($data);

    }
}
