<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class UsersFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {}

    public function load(ObjectManager $manager): void
    {

        $faker = Faker\Factory::create('fr-FR');

        for($usr = 1; $usr <= 5 ; $usr++){
            $user = new User;
            $user->setName($faker->lastName)
            ->setFirstName($faker->firstName)
            ->setAdress($faker->address)
            ->setPhone(234543)
            ->setUserName($faker->userName)
            ->setEmail($faker->email)
            ->setPassword(
                $this->passwordEncoder->hashPassword($user, 'secret')
            )
            ->setRoles(['ROLE_USER']);
            
            $manager->persist($user);
        }

        $manager->flush();
    }
}
