<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\CatalogArticle;
use App\Entity\SousArticle;
use App\Entity\sousCategorie;
use App\Form\ArticleType;
use App\Form\SousArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AddSousArticleController extends AbstractController
{
    /**
     * @Route("/admin/add/sous/article/{id?0}", name="add_sous_article")
     */
    public function index(Request $request,SluggerInterface $slugger, EntityManagerInterface $manager, SousArticle $sousArticle=null )
    {
        $test=false;
        if(!$sousArticle){
            $test=true;
            $sousArticle= new SousArticle();
        }
        $sousArticle->addTabDimension('dim1');
        $form = $this->createForm(SousArticleType::class, $sousArticle);
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
                    $sousArticle->addImage($newFilename);
                }
            }

            $manager->persist($sousArticle);
            $manager->flush();
            if ($test==false){
                $this->addFlash('success',"Sous article edité avec succès");
            }else{
                $this->addFlash('success',"Sous article ajouté avec succès");
            }
            return $this->redirectToRoute('sousArticleList');
        }

        return $this->render('add_sous_article/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/sous/article/list",name="sousArticleList")
     */
    public function main()
    {
        return$this->render('add_sous_article/listSousArticle.html.twig');
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/sousArticles",name="sousArticles")
     */

    public function list(Request $request)
    {
        $start = $request->query->get("start");
        $length = $request->query->get("length");
        $draw = $request->query->get("draw");
        $search = $request->query->get("search");
        $order = $request->query->get('order');
        $filter= $request->query->get('filter');
//        search tekhdem mrigla
        $articles = $this->getDoctrine()->getRepository(SousArticle::class)->findByFilter($search["value"],$length,$start);
        $data = array();
        $result = array();
        $idx = 0;
        foreach ($articles as $article) {
            $operatorArray= array();
            $operatorArray[]= $article->getId();
            $operatorArray[]= $article->getCatalogArticle()->getNom();
            $operatorArray[]= $article->getNom();
            $operatorArray[]= $article->getTabDimension();
            $operatorArray[]= $article->getDescription();
            $operatorArray[]=$this->render('add_sous_article/actions.html.twig',['article'=>$article])->getContent();
            $result[] = $operatorArray;
        };
        $count = count($this->getDoctrine()->getRepository(CatalogArticle::class)->findAll());
        $data['draw'] = $draw;
        $data['recordsTotal'] = $count;
        $data['recordsFiltered'] = $count;
        $data['data'] = $result;
        return new JsonResponse($data);

    }
    /**
     * @Route("admin/delete/sous/article/{id}",name="admin_delete_sous_article")
     */

    public function deleteCategory(Request $request,SousArticle $article){
        $manager=$this->getDoctrine()->getManager();
        $manager->remove($article);
        $manager->flush();
        $this->addFlash('deleted','Sous article deleted successfully');
        return $this->redirectToRoute("sousArticleList");

    }
    /**
     * @Route("admin/promotion/sous/article/{id}",name="admin_promotion_sous_article")
     */
    public function PromotionArticle(Request $request, SousArticle $article){
        $promotion= $request->get('promotion');
        $article->setPromotion($promotion);
        $manager=$this->getDoctrine()->getManager();
        $manager->persist($article);
        $manager->flush();
        $this->addFlash('success','sous article mis en promotion');
        return $this->redirectToRoute("sousArticleList");


    }
}
