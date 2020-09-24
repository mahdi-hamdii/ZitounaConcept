<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact/{id}", name="contact")
     */
    public function index(Request $request,Article $article)
    {
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $form=$this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
        $contact=$form->getData();
        //ici nous enverrons le mail
            dd($contact);
        }
            return $this->render('contact/index.html.twig', [
                'contactform' => $form->createView(),
                'categories'=>$categories
            ]);

    }
}
