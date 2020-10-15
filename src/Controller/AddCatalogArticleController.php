<?php

namespace App\Controller;

use App\Entity\CatalogArticle;
use App\Entity\Categorie;
use App\Form\CatalogArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AddCatalogArticleController extends AbstractController
{
    /**
     * @Route("/admin/add/catalogue/article/{id?0}", name="add_catalogue_article")
     */
    public function index(Request $request,SluggerInterface $slugger, EntityManagerInterface $manager,CatalogArticle $catalogue=null )
    {
        $test=false;
        if(!$catalogue){
            $catalogue= new CatalogArticle();
            $test=true;
        }
        $form = $this->createForm(CatalogArticleType::class, $catalogue);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($image) {
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
                $catalogue->setImage($newFilename);
            }
            $manager->persist($catalogue);
            $manager->flush();
            if ($test=false){
                $this->addFlash('success','catalogue d\'article edité avec succès');
            }else{
                $this->addFlash('success','catalogue d\'article ajouté avec succès');

            }
            return $this->redirectToRoute('catalogue_article_list');
        }

        return $this->render('add_catalogue_article/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/catalogue/article/list",name="catalogue_article_list")
     */
    public function list(Request $request){
        $catalogArticle=$this->getDoctrine()->getRepository(CatalogArticle::class)->findAll();
        return $this->render('add_catalogue_article/list.html.twig',[
            'catalogueArticle'=>$catalogArticle
        ]);
    }
    /**
     * @Route("/admin/catalogue/article/delete/{id}",name="delete_catalogue_article")
     */
    public function deleteCatalogue(Request $request,CatalogArticle $catalogArticle){
        $manager=$this->getDoctrine()->getManager();
        $manager->remove($catalogArticle);
        $manager->flush();
        $this->addFlash('deleted','catalgoue d\'article deleted successfully');
        return $this->redirectToRoute("catalogue_article_list");

    }
}
