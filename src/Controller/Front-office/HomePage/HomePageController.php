<?php

namespace App\Controller;

use App\Repository\Back_office\Product\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(ProductRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $products = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        
        
        return $this->render('pages/index.html.twig', [
            'controller_name' => 'HomePageController',
            'products' => $products
        ]);
    }
}
