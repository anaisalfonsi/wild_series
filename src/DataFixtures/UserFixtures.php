<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;
use Faker;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

     public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $subscriber = new User();
        $subscriber->setEmail('subscriber@monsite.com');
        $subscriber->setRoles(['ROLE_SUBSCRIBER']);
        $subscriber->setPassword($this->passwordEncoder->encodePassword(
            $subscriber,
            'sublife'
        ));
        $subscriber->setFirstname('Ricardo');

        $manager->persist($subscriber);

        $admin = new User();
        $admin->setEmail('admin@monsite.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'admin'
        ));

        $manager->persist($admin);

        $faker = Faker\Factory::create('en_US');
        for ($i = 0; $i < 50; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setRoles(['ROLE_SUBSCRIBER']);
            $user->setFirstname($faker->firstName);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $subscriber,
                'sublife'
            ));
            $manager->persist($user);
            $this->addReference('author_' .$i, $user);
        }
        $manager->flush();
    }
}
