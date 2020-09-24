<?php

namespace App\Controller;

use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SecondPageController extends AbstractController
{
    /**
     * @Route("/categorie/{id}", name="second_page")
     */
    public function index(Request $request, Categorie $categorie)
    {
        $sousCategories=$categorie->getSousCategories();
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        return $this->render('second_page/index.html.twig', [
            'sousCategories' => $sousCategories,
            'categorie'=>$categorie,
            'categories'=>$categories
        ]);
    }
}
