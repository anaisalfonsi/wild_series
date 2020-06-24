<?php


namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;


class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('en_US');
        for ($i = 0; $i < 80; $i++) {
            $episode = new Episode();
            $episode->setSeason($this->getReference('season_' . $faker->numberBetween(0, 14)));
            $episode->setTitle($faker->sentence);
            $episode->setNumber($faker->numberBetween(1, 10));
            $episode->setSynopsis($faker->text);
            $episode->setPhoto($faker->imageUrl($width = 213, $height = 160));
            $manager->persist($episode);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [SeasonFixtures::class];
    }
}