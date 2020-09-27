<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Project;
use App\Entity\sousCategorie;
use App\Form\ArticleType;
use App\Form\ProjectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProjectController extends AbstractController
{
    /**
     * @Route("/admin/add/project/{id?0}", name="add_project")
     */
    public function index(Request $request,SluggerInterface $slugger, EntityManagerInterface $manager, Project $project=null )
    {
        $test=false;
        if(!$project){
            $test=true;
            $project= new Project();
        }
        $form = $this->createForm(ProjectType::class, $project);
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
                    $project->addImage($newFilename);
                }
            }

            $manager->persist($project);
            $manager->flush();
            if ($test==false){
                $this->addFlash('success',"Project edité avec succès");
            }else{
                $this->addFlash('success',"Project ajouté avec succès");
            }
            return $this->redirectToRoute('projectList');
        }

        return $this->render('add_project/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/project/list",name="projectList")
     */
    public function main()
    {
        $cats = $this->getDoctrine()->getRepository(sousCategorie::class)->findAll();
        return$this->render('add_project/listProject.html.twig',[
            'sousCategories'=>$cats
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/projects",name="projects")
     */

    public function list(Request $request)
    {
        $start = $request->query->get("start");
        $length = $request->query->get("length");
        $draw = $request->query->get("draw");
        $search = $request->query->get("search");
        $order = $request->query->get('order');
        $projects= $this->getDoctrine()->getRepository(Project::class)->findAll();
        $data = array();
        $result = array();
        $idx = 0;
        foreach ($projects as $project) {
            $operatorArray= array();
            $operatorArray[]= $project->getId();
            $operatorArray[]= $project->getNom();
            $operatorArray[]= $project->getDimension();
            $operatorArray[]= $project->getRetour();
            $operatorArray[]=$this->render('add_project/actions.html.twig',['project'=>$project])->getContent();
            $result[] = $operatorArray;
        };
        $count = count($this->getDoctrine()->getRepository(Project::class)->findAll());
        $data['draw'] = $draw;
        $data['recordsTotal'] = $count;
        $data['recordsFiltered'] = $count;
        $data['data'] = $result;
        return new JsonResponse($data);

    }
    /**
     * @Route("admin/delete/project/{id}",name="admin_delete_project")
     */

    public function deleteCategory(Request $request,Project $project){
        $manager=$this->getDoctrine()->getManager();
        $manager->remove($project);
        $manager->flush();
        $this->addFlash('deleted','project deleted successfully');
        return $this->redirectToRoute("projectList");

    }
}
