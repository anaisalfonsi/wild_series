<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Actor;
use App\Entity\Program;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i = 1; $i <= 1000; $i++) {
            $category = new Category();
            $category->setName($faker->word);
            $manager->persist($category);
            $this->addReference("category_".$i, $category);

            $program = new Program();
            $program->setTitle($faker->sentence(4, true));
            $program->setSummary($faker->text(100));
            $program->setCategory($this->getReference("category_" . $i));
            $program->setCountry($faker->country);
            $program->setYear($faker->year($max = 'now'));
            $this->addReference("program_".$i, $program);
            $manager->persist($program);

            for($j = 1; $j <= 5; $j ++) {
                $actor = new Actor();
                $actor->setFirstname($faker->firstName);
                $actor->setLastname($faker->lastName);
                $actor->setBirthday($faker->dateTimeBetween($startDate = '-70 years', $endDate = 'now', $timezone = null));
                $actor->addProgram($this->getReference("program_".$i));
                $manager->persist($actor);
            }

        }

        $manager->flush();
    }
}
