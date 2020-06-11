<?php

namespace App\Controller;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Season;
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

        foreach ($programs as $key) {
            //$id = $key->getId();
            /*$program = $this->getDoctrine()
                ->getRepository(Program::class)
                ->findOneBy(['id' => $id]);*/
            $programTitle = $key->getTitle();
            $slug = preg_replace(
                '/ /',
                '-', mb_strtolower($programTitle));
        }

        return $this->render('wild/index.html.twig', [
            'programs' => $programs,
            'slug' => $slug
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="show")
     */
    public function show(Program $program)
    {
        $actors = $program->getActors();
        return $this->render('wild/show.html.twig', [
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
        $id = $category->getId();
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(['category' => $id],
                ['id' => 'desc'],
                3);

        return $this->render('wild/category.html.twig', [
            'category' => $categoryName,
            'programs' => $programs
        ]);
    }

    /**
     * @param string $slug
     * @Route("/program/{slug<[a-z0-9-]+>}", defaults={"slug" = null}, methods={"GET"}, name="show_program")
     */
    public function showByProgram(string $slug)
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
        $programId = $program->getId();

        $seasons = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findBy(['program' => $programId],
                ['year' => 'desc'],
                3);

        return $this->render('wild/program.html.twig', [
            'slug' => $slug,
            'program' => $program,
            'seasons' => $seasons
        ]);
    }

    /**
     * @param int $id
     * @Route("/season/{id}", defaults={"id" = null}, methods={"GET"}, name="show_season")
     */
    public function showBySeason(int $id)
    {
        if (!$id) {
            throw $this
                ->createNotFoundException("No id has been sent to find a season in season's table.");
        }

        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->findOneBy(['id' => ($id)]);

        $programId = $season->getProgram();
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => ($programId)]);

        $episodes = $season->getEpisodes();

        return $this->render('wild/season.html.twig', [
            'program' => $program,
            'episodes' => $episodes,
            'season' => $season
        ]);
    }

    /**
     * @Route("/episode/{id}", name="show_episode")
     */
    public function showEpisode(Episode $episode)
    {
        $season = $episode->getSeason();
        $program = $season->getProgram();
        $programTitle = $program->getTitle();
        $slug = preg_replace(
            '/ /',
            '-', mb_strtolower($programTitle));

        return $this->render('wild/episode.html.twig', [
            'episode' => $episode,
            'season' => $season,
            'program' => $program,
            'slug' => $slug
        ]);
    }

    /**
     * @Route("/actor/{id}", name="show_actor")
     */
    public function showActor(int $id)
    {
        $actor = $this->getDoctrine()
            ->getRepository(Actor::class)
            ->findOneBy(['id' => ($id)]);

        $programs = $actor->getPrograms();

        return $this->render('wild/actor.html.twig', [
            'actor' => $actor,
            'programs' => $programs
        ]);
    }
}
