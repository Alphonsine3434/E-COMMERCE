<?php

namespace App\DataFixtures;

use App\Entity\Supplier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SupplierFixtures extends Fixture
{
    private $counter = 1;
    public function load(ObjectManager $manager): void
    {
        
        $mots_supplier = ['Mycar.', 'Driver', 'CarLuxe', 'SpecialCar'];
        
        for($i=0; $i<3; $i++){
            $supplier = new Supplier();
            $supplier->setName($mots_supplier[$i]);
            $supplier->setReference('fournisseur-'.$i);
            
            $manager->persist($supplier);

            $this->addReference('supplier-'.$this->counter, $supplier);
            $this->counter++;  
        }

        $manager->flush();
    }
}
