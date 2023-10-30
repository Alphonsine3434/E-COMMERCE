<?php

namespace App\Controller\Front_office\HomePage;

use App\Repository\Back_office\Brands\BrandsRepository;
use App\Repository\Back_office\Product\ProductRepository;
use App\Repository\Back_office\Supplier\SupplierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home_index', methods: ['GET'] )]
    public function index(
            ProductRepository $repositoryProduct,
            BrandsRepository $repositoryBrands, 
            SupplierRepository $supplierRepository 
        ): Response
    {

        $products = $repositoryProduct->findAll();

        $brands = $repositoryBrands->findAll();

        $suppliers =  $supplierRepository->findAll();

        return $this->render('Front_office/HomePage_front/index.html.twig'
        , [
            'products' => $products,
            'brands' => $brands,
            'suppliers' => $suppliers
        ]);
    }
}

