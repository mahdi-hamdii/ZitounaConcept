<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\sousCategorie;
use App\Form\CategorieType;
use App\Form\SousCategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AddSousCategorieController extends AbstractController
{
    /**
     * @Route("/admin/add/sous/categorie/{id?0}", name="add_sous_categorie")
     */
    public function index(Request $request,SluggerInterface $slugger, EntityManagerInterface $manager,sousCategorie $sousCategorie=null )
    {
        $test=false;
        if(!$sousCategorie){
            $sousCategorie= new sousCategorie();
            $test=true;
        }
        $form = $this->createForm(SousCategorieType::class, $sousCategorie);
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
                $sousCategorie->setImage($newFilename);
            }
            $manager->persist($sousCategorie);
            $manager->flush();
            if ($test=false){
                $this->addFlash('success','sous categorie edité avec succès');
            }else{
                $this->addFlash('success','sous categorie ajouté avec succès');

            }
            return $this->redirectToRoute('sous_categorie_list');
        }

        return $this->render('add_sous_categorie/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/sous/categorie/list",name="sous_categorie_list")
     */
    public function list(Request $request){
       $categorie= $request->get('categorie');
       if($categorie){
         $categorie=$this->getDoctrine()->getRepository(Categorie::class)->find($categorie);
       }
        $page = $request->query->get('page') ?? 1 ;
        $sousCategories=$this->getDoctrine()->getRepository(sousCategorie::class);
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $nbreEnregistrements=count($sousCategories->findAll());
        $nbpage=($nbreEnregistrements%10)?(intdiv($nbreEnregistrements,10))+1:(intdiv($nbreEnregistrements,10));
            $sousCategories = $sousCategories->findBy(
                ['categorie'=>$categorie],array('id'=>'ASC'),10, ($page -1 ) * 10 );
        return $this->render('add_sous_categorie/list.html.twig',[
            'souscategories'=>$sousCategories,
            'nbpage'=>$nbpage,
            'categories'=>$categories
        ]);
    }
    /**
     * @Route("/admin/sous/categorie/delete/{id}",name="delete_sous_categorie")
     */
    public function deleteCategory(Request $request,sousCategorie $sousCategorie){
        $manager=$this->getDoctrine()->getManager();
        $manager->remove($sousCategorie);
        $manager->flush();
        $this->addFlash('deleted','sous categorie deleted successfully');
        return $this->redirectToRoute("sous_categorie_list");

    }
}
