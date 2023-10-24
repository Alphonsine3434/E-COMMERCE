<?php

namespace App\DataFixtures\Supplier;

use App\Entity\Supplier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SupplierFixtures extends Fixture
{
    private $counter = 1;
    public function load(ObjectManager $manager): void
    {
        
        $mots_supplier = ['Mycar.', 'Driver', 'CarLuxe', 'SpecialCar'];
        
        for($i=0; $i<20; $i++){
            $supplier = new Supplier();
            $supplier->setName($mots_supplier[mt_rand(0,3)]);
            $supplier->setReference('fournisseur-'.$i);
            
            $manager->persist($supplier);

            $this->addReference('supplier-'.$this->counter, $supplier);
            $this->counter++;  
        }

        $manager->flush();
    }
}
