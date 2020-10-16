<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Services;
use App\Entity\SousArticle;
use App\Entity\SousService;
use App\Form\ServiceType;
use App\Form\SousServiceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class SousServiceController extends AbstractController
{
    /**
     * @Route("/sous/service/{id}", name="sous_service")
     */
    public function index(Services $services)
    {
        $sousService=$services->getSousServices();
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('sous_service/index.html.twig', [
            'categories' => $categories,
            'sousServices'=>$sousService,
            'service'=>$services
        ]);
    }
    /**
     * @Route("/admin/add/sous/service/{id?0}", name="add_sous_service")
     */
    public function addSousService(Request $request,SluggerInterface $slugger, EntityManagerInterface $manager,SousService $service=null )
    {
        if(!$service)
        {
            $service= new SousService();
        }
        $form = $this->createForm(SousServiceType::class, $service);
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
                $service->setImage($newFilename);
            }
            $manager->persist($service);
            $manager->flush();
            $this->addFlash('success', 'Sous service added successfully');
            return $this->redirectToRoute('sous_service_list');
        }

        return $this->render('sous_service/addSousService.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/sous/service/list",name="sous_service_list")
     */
    public function list(){
        $categories=$this->getDoctrine()->getRepository(SousService::class)->findAll();
        return $this->render('sous_service/listSousService.html.twig',[
            'categories'=>$categories
        ]);
    }
}
