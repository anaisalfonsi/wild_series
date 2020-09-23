<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;

class TwigTemplateController extends AbstractController
{
    public function showsCategories(CategoryRepository $categoryRepository)
    {
        $categories = $categoryRepository->findCategories();

        return $this->render('twig_template/_showsCategories.html.twig', [
            'categories' => $categories
        ]);
    }
}
