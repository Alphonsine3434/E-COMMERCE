<?php

namespace App\DataFixtures;

use App\Entity\Brands;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BrandsFixtures extends Fixture implements DependentFixtureInterface
{
    private $counter = 1;
    public function load(ObjectManager $manager): void
    {   
        $mots_brands = ['Citroën.', 'Volkswagen', 'Opel', 'Toyota', 'Ferrari.'];
        
        for($i=0; $i<20; $i++){
            $brands = new Brands();
            $brands->setName($mots_brands[mt_rand(0,4)]);
            
            //On va chercher fournisseur du marque
            $supplier = $this->getReference('supplier-'.rand(1,20));
            $brands->setSupplier($supplier);

            $manager->persist($brands);


            $this->addReference('brand-'.$this->counter, $brands);
            $this->counter++;  
        }

        

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SupplierFixtures::class
        ];
    }
}
