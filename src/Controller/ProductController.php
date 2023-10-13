<?php

namespace App\Controller;

use App\Entity\Product;  
use App\Form\ProductsType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * This controller display all products
     *
     * @param ProductRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */

    #[Route('/product', name: 'product.index', methods: ['GET'] )]
    public function index(ProductRepository $repository, PaginatorInterface $paginator, Request $request ): Response
    {
    
        $products = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        
        return $this->render('pages/product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products
        ]);
    }

    
    #[Route('/product/new', name: 'product.new', methods: ['GET', 'POST'] )]
    public function new(
        Request $request,
        EntityManagerInterface $manager,
    ): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductsType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $product = $form->getData();

            $manager->persist($product);

            $manager->flush();

            $this->addFlash(
                'success',
                'Votre produit a été créé avec succés'
            );    

            return $this->redirectToRoute('product.index');
        }

        return $this->render('pages/product/new.html.twig', [  
            'form' => $form->createView()
        ]);
    }

    #[Route('/product/edition/{id}', name: 'product.edit', methods: ['GET', 'POST'] )]
    public function edit(
        Product $product,
        Request $request,
        EntityManagerInterface $manager
        
    ): Response 
    {
        
        $form = $this->createForm(ProductsType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $product = $form->getData();

            $manager->persist($product);

            $manager->flush();

            $this->addFlash(
                'success',
                'Votre produit a été modifié avec succés'
            );    

            return $this->redirectToRoute('product.index');
        }

        return $this->render('pages/product/new.html.twig', [  
            'form' => $form->createView()
        ]);
    }

    #[Route('/product/suppression/{id}', name: 'product.delete', methods: ['GET'] )]
    public function delete(EntityManagerInterface $manager, Product $product): Response
    {

        if(!$product){
            $this->addFlash(
                'warning',
                'Le produit en question n\' a pas été trouvé'
            );    
    
            return $this->redirectToRoute('product.index');
        }

        $manager->remove($product);
        
        $manager->flush();
 
        $this->addFlash(
            'success',
            'Votre produit a été supprimé avec succés'
        );    

        return $this->redirectToRoute('product.index');
    }
}
