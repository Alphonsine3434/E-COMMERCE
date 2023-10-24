<?php

namespace App\DataFixtures\User;

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
        $admin = new User();
        $admin->setName('RASOA')
            ->setFirstName('Alphonsine')
            ->setAdress('Fenoarivo')
            ->setPhone(34545)
            ->setEmail('ras@gmail.com')
            ->setPassword(
                $this->passwordEncoder->hashPassword($admin, 'admin')
            )
            ->setRoles(['ROLE_ADMIN']);

         $manager->persist($admin);

        $faker = Faker\Factory::create('fr-FR');

        for($usr = 1; $usr <= 5 ; $usr++){
            $user = new User;
            $user->setName($faker->lastName)
            ->setFirstName($faker->firstName)
            ->setAdress($faker->address)
            ->setPhone(234543)
            ->setEmail($faker->email)
            ->setPassword(
                $this->passwordEncoder->hashPassword($user, 'secret')
            );
            
            $manager->persist($user);
        }

        $manager->flush();
    }
}
