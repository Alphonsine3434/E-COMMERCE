<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {}

    public function load(ObjectManager $manager): void
    {
        $admin = new Admin();

        $admin->setUserName('Admin')
            ->setEmail('admin@gmail.com')
            ->setPassword(
                $this->passwordEncoder->hashPassword($admin, 'admin')
            )
            ->setRoles(['ROLE_ADMIN']);

         $manager->persist($admin);

        $admin = new Admin();

        $admin->setUserName('Alphonsine')
            ->setEmail('alphonsine@gmail.com')
            ->setPassword(
                $this->passwordEncoder->hashPassword($admin, 'alphonsine')
            )
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $manager->flush();
    }
}
