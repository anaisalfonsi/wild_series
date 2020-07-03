<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Comment;
use Faker;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('en_US');
        for ($i = 0; $i < 100; $i++) {
            $comment = new Comment();
            $comment->setComment($faker->text);
            $comment->setRate($faker->numberBetween(0, 10));
            for ($b = 0; $b < 50; $b++) {
                $comment->setAuthor($this->getReference('author_' . $faker->numberBetween(1, 49)));
                $comment->setEpisode($this->getReference('episode_' . $faker->numberBetween(1, 79)));
            }
            $manager->persist($comment);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [UserFixtures::class, EpisodeFixtures::class];
    }
}
