<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AddCategorieController extends AbstractController
{
    /**
     * @Route("/admin/add/categorie/{id?0}", name="add_categorie")
     */
    public function index(Request $request,SluggerInterface $slugger, EntityManagerInterface $manager, Categorie $categorie=null )
    {
        if(!$categorie)
        {
            $categorie= new Categorie();
        }
        $form = $this->createForm(CategorieType::class, $categorie);
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
                $categorie->setImage($newFilename);
            }
            $manager->persist($categorie);
            $manager->flush();
            $this->addFlash('success', 'categorie added successfully');
            return $this->redirectToRoute('add_categorie');
        }

        return $this->render('add_categorie/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/categorie/list",name="categorie_list")
     */
    public function list(){
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('add_categorie/listCategorie.html.twig',[
            'categories'=>$categories
        ]);
    }
    /**
     * @Route("/admin/categorie/delete/{id}",name="delete_categorie")
     */
    public function deleteCategory(Request $request,Categorie $categorie){
        $manager=$this->getDoctrine()->getManager();
        $manager->remove($categorie);
        $manager->flush();
        $this->addFlash('deleted','categorie deleted successfully');
        return $this->redirectToRoute("categorie_list");

    }
}
