<?php

namespace App\Controller\Back_office\Product;

use App\Entity\Product; 
use App\Form\Product\ProductsType;
use App\Repository\Back_office\Product\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
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

    #[Route('/admin/product/liste', name: 'app_product_liste', methods: ['GET'] )]
    public function index(ProductRepository $repository, PaginatorInterface $paginator, Request $request ): Response
    {
    
        $products = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        
        return $this->render('Back_office/Product/index.html.twig', [
            'products' => $products
        ]);
    }

    
    #[Route('/admin/product/new', name: 'app_product_new', methods: ['GET', 'POST'] )]
    public function new(Request $request, EntityManagerInterface $manager): Response
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

            return $this->redirectToRoute('app_product_liste');
        }

        return $this->render('Back_office/Product/new.html.twig', [  
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/product/edit/{id}', name: 'app_product_edit', methods: ['GET', 'POST'] )]
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

            return $this->redirectToRoute('app_product_liste');
        }

        return $this->render('Back_office/Product/edit.html.twig', [  
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/product/delete/{id}', name: 'app_product_delete', methods: ['GET'] )]
    public function delete(EntityManagerInterface $manager, Product $product, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $manager->remove($product);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre produit a été supprimé avec succés'
            );    
        }
 
        return $this->redirectToRoute('app_product_liste');
    }
}