<?php

namespace App\Controller\Front_office\HomePage;

use App\Repository\Back_office\Brands\BrandsRepository;
use App\Repository\Back_office\Product\ProductRepository;
use App\Repository\Back_office\Supplier\SupplierRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home_index', methods: ['GET'] )]
    public function index(
        ProductRepository $repositoryProduct,
        BrandsRepository $repositoryBrands, 
        SupplierRepository $supplierRepository,
        PaginatorInterface $paginator, 
        Request $request ): Response
    {

        $products = $paginator->paginate(
            $repositoryProduct->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        $brands = $paginator->paginate(
            $repositoryBrands->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        $suppliers = $paginator->paginate(
            $supplierRepository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('Front_office/HomePage_front/index.html.twig'
        , [
            'products' => $products,
            'brands' => $brands,
            'suppliers' => $suppliers
        ]);
    }
}

