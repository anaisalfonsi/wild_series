<?php


namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('en_US');
        for ($i = 0; $i < 15; $i++) {
            $season = new Season();
            $season->setProgram($this->getReference('program_' . $faker->numberBetween(0, 5)));
            $season->setNumber($faker->numberBetween(1, 3));
            $season->setYear($faker->year);
            $season->setDescription($faker->text);
            $manager->persist($season);
            $this->addReference('season_' .$i, $season);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}