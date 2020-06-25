<?php


namespace App\DataFixtures;

use App\Entity\Actor;
use App\Services\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    const ACTORS = [
        'Jamie Lee Curtis',
        'Emma Roberts',
        'Billie Lourd'
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::ACTORS as $key => $name) {
            $actorMano = new Actor();
            $actorMano->setName($name);
            $slugify = new Slugify();
            $slug = $slugify->generate($name);
            $actorMano->setSlug($slug);
            $manager->persist($actorMano);
            $actorMano->addProgram($this->getReference('program_2'));
        }

        $faker = Faker\Factory::create('en_US');
        for ($i = 0; $i < 50; $i++) {
            $actor = new Actor();
            $actor->setName($faker->name);
            $slugify = new Slugify();
            $slug = $slugify->generate($actor->getName());
            $actor->setSlug($slug);
            $actor->getPrograms();
            $manager->persist($actor);
            $this->addReference('actor_' .$i, $actor);
            for ($nbProg = 0; $nbProg < 6; $nbProg ++) {
                $actor->addProgram($this->getReference('program_' . $nbProg));
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}