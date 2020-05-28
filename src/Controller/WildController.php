<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;

/**
 * @Route("/wild", name="wild_")
 */
class WildController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        if (!$programs) {
            throw $this->createNotFoundException("No program found in program's table.");
        }
        return $this->render('wild/index.html.twig', [
            'programs' => $programs,
        ]);
    }

    /**
     * @param string $slug The slugger
     * @Route("/show/{slug<[a-z0-9-]+>}", defaults={"slug" = null}, methods={"GET"}, name="show")
     */
    public function show(string $slug)
    {
        if (!$slug) {
            throw $this
            ->createNotFoundException("No slug has been sent to find a program in program's table.");
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);
        if (!$program) {
            throw $this->createNotFoundException(
                "No program with '.$slug.' title, found in program's table."
            );
        }

        return $this->render('wild/show.html.twig', [
            'slug' => $slug,
            'program' => $program
        ]);
    }

    /**
     * @param string $categoryName
     * @Route("/category/{categoryName<[a-z0-9-]+>}", defaults={"categoryName" = null}, name="show_category")
     */
    public function showByCategory(string $categoryName)
    {
        if (!$categoryName) {
            throw $this
                ->createNotFoundException("No category has been sent.");
        }

        $categoryName = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($categoryName)), "-")
        );

        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findOneBy(['name' => mb_strtolower($categoryName)]);
        if (!$category) {
            throw $this->createNotFoundException(
                "No category with '.$categoryName.' name, found in category's table."
            );
        }
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => 1],
                ['id' => 'desc'],
                3);

        return $this->render('wild/category.html.twig', [
            'category' => $categoryName,
            'programs' => $programs
        ]);
    }
}
