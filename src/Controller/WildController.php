<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wild", name="wild_")
 */
class WildController extends AbstractController
{
    /**
     * @Route("/show/{slug<[a-z0-9-]+>}", methods={"GET"}, name="show")
     */
    public function show(string $slug = NULL)
    {
        $string = explode('-', $slug);
        $title = ucwords(strtolower(implode(' ', $string)));

        return $this->render('wild/show.html.twig', [
            'slug' => $slug,
            'title' => $title
        ]);
    }
}
