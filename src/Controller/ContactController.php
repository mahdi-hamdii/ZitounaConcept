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
     * @Route("/contact/{id}", name="contact_article")
     */
    public function index(Request $request,Article $article,\Swift_Mailer $mailer)
    {
        $categories=$this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $form=$this->createForm(ContactType::class,['action'=>$this->generateUrl('contact',['id'=>$article->getId()])]);
        $form->handleRequest($request);
        if ($form->isSubmitted()&&$form->isValid()){
            $contact=$form->getData();

        //ici nous enverrons le mail
            $message = ( new \Swift_Message('Demande Devis'))
                ->setFrom($contact['email'])
                ->setTo('mahdihamdi@live.fr')
                ->setBody(
                    $this->renderView(
                        'contact/email.html.twig',['contact'=>$contact,'article'=>$article]
                    ),
                    'text'
                );
            //on  envoie le message
            $mailer->send($message);
            $this->addFlash('success','votre demande devis sera traité le plutot possible');
            return $this->redirectToRoute('third_page',['id'=>$article->getId()]);
        }else{


            return $this->render('contact/index.html.twig', [
                'contactform' => $form->createView(),
                'categories'=>$categories
            ]);
        }
    }
}
