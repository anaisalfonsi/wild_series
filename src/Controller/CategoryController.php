<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Services\Slugify;

/**
 * @Route("/category", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        foreach ($categories as $category) {
            $name = $category->getName();
            $categoryName = mb_strtolower($name);
        }

        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'categoryName' => $categoryName
        ]);
    }

    /**
     * @Route("/add", name="add", methods="GET|POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @IsGranted("ROLE_ADMIN")
     */
    public function add(Request $request, Slugify $slugify)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $insert = $this->getDoctrine()->getManager();
            $slug = $slugify->generate($category->getName());
            $category->setSlug($slug);
            $insert->persist($category);
            $insert->flush();

            $this->addFlash('success', 'The new category has been created');

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
