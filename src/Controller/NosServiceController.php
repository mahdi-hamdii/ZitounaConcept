<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Services;
use App\Form\CategorieType;
use App\Form\ServiceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class NosServiceController extends AbstractController
{
    /**
     * @Route("/nos/service", name="nos_service")
     */
    public function index()
    {
        $service=$this->getDoctrine()->getRepository(Services::class)->findAll();
        $categories= $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('nos_service/index.html.twig', [
            'categories' => $categories,
            'services'=>$service
        ]);
    }
    /**
     * @Route("/admin/add/service/{id?0}", name="add_service")
     */
    public function addService(Request $request,SluggerInterface $slugger, EntityManagerInterface $manager,Services $service=null )
    {
        if(!$service)
        {
            $service= new Services();
        }
        $form = $this->createForm(ServiceType::class, $service);
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
            $this->addFlash('success', 'service added successfully');
            return $this->redirectToRoute('service_list');
        }

        return $this->render('nos_service/addService.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/service/list",name="service_list")
     */
    public function list(){
        $categories=$this->getDoctrine()->getRepository(Services::class)->findAll();
        return $this->render('nos_service/listService.html.twig',[
            'categories'=>$categories
        ]);
    }
    /**
     * @Route("/admin/service/delete/{id}",name="delete_service")
     */
    public function deleteCategory(Request $request,Services $services){
        $manager=$this->getDoctrine()->getManager();
        $sousServices=$services->getSousServices();
        foreach ($sousServices as $sousService ){
            $manager->remove($sousService);
        }
        $manager->remove($services);
        $manager->flush();
        $this->addFlash('deleted','service deleted successfully');
        return $this->redirectToRoute("service_list");

    }
}
