<?php

namespace App\DataFixtures;

Use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $mots_types = ['BMW', 'Peugeot', 'Mercedes'];
        $mots_gender = ['Limousine', 'Personnelle', 'Tracteur', 'Plaisir', 'Marchandise'];

        for($i=0; $i<20; $i++){
            $product = new Product();
            $product->setTitle("Produit $i")
                ->setDescription("Produit spéciale $i")
                ->setQuantityStock(mt_rand(1,30))
                ->setPrice(mt_rand(100,200))
                ->setTypes($mots_types[mt_rand(0,2)])
                ->setGender($mots_gender[mt_rand(0,4)]);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
