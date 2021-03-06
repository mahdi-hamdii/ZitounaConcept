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
     * @Route("/admin/add/article/{id?0}", name="add_article")
     */
    public function index(Request $request,SluggerInterface $slugger, EntityManagerInterface $manager, Article $article=null )
    {
        $test=false;
        if(!$article){
            $test=true;
            $article= new Article();
        }
        $article->addTabDimension('dim1');
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
            if ($test==false){
                $this->addFlash('success',"Article edité avec succès");
            }else{
                $this->addFlash('success',"Article ajouté avec succès");
            }
            return $this->redirectToRoute('articleList');
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
//        search tekhdem mrigla
        $cat=$this->getDoctrine()->getRepository(sousCategorie::class)->findOneBy(['nom'=>$cat]);
        $articles = $this->getDoctrine()->getRepository(Article::class)->findBySousCategorie($cat,$search["value"],$length,$start);
        $data = array();
        $result = array();
        $idx = 0;
        foreach ($articles as $article) {
            $operatorArray= array();
            $operatorArray[]= $article->getId();
            $operatorArray[]= $article->getSousCategorie()->getNom();
            $operatorArray[]= $article->getNom();
            $operatorArray[]= $article->getTabDimension();
            $operatorArray[]= $article->getDescription();
            $operatorArray[]=$this->render('add_article/actions.html.twig',['article'=>$article])->getContent();
            $result[] = $operatorArray;
        };
        $count = count($this->getDoctrine()->getRepository(Article::class)->findAll());
        $data['draw'] = $draw;
        $data['recordsTotal'] = $count;
        $data['recordsFiltered'] = $count;
        $data['data'] = $result;
        return new JsonResponse($data);

    }
    /**
     * @Route("admin/delete/article/{id}",name="admin_delete_article")
     */

    public function deleteCategory(Request $request,Article $article){
        $manager=$this->getDoctrine()->getManager();
        $manager->remove($article);
        $manager->flush();
        $this->addFlash('deleted','article deleted successfully');
        return $this->redirectToRoute("articleList");

    }
    /**
     * @Route("admin/promotion/article/{id}",name="admin_promotion_article")
     */
    public function PromotionArticle(Request $request, Article $article){
        $promotion= $request->get('promotion');
        $article->setPromotion($promotion);
        $manager=$this->getDoctrine()->getManager();
        $manager->persist($article);
        $manager->flush();
        $this->addFlash('success','article mis en promotion');
        return $this->redirectToRoute("articleList");


    }
}
