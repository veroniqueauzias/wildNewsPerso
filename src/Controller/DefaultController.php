<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy([], ['id'=> 'desc'], 3);

        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findby([], ['title' => 'asc']);

        return $this->render('index.html.twig', [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/categorie/{id}", name="categorie")
     */
    public function showCategory(int $id)
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        if(!$category)
            throw new NotFoundHttpException('Cette catégorie n\'existe pas');

        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findBy(['category' => $category], ['id'=>'desc']);

        return $this->render('category.html.twig', [
            'category' => $category,
            'articles' => $articles
        ]);
    }
}

