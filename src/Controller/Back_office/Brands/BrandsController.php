<?php

namespace App\Controller\Back_office\Brands;

use App\Entity\Brands;
use App\Form\Brands\BrandsType;
use App\Repository\Back_office\Brands\BrandsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrandsController extends AbstractController
{
    #[Route('/admin/brands', name: 'admin_brands_index', methods: ['GET'] )]
    public function index(
        BrandsRepository $repository, 
        PaginatorInterface $paginator, 
        Request $request ): Response
    {
    
        $brands = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        
        return $this->render('Back_office/Brands/index.html.twig', [
            'brands' => $brands
        ]);
    }

    #[Route('/admin/brands/new', name: 'admin_brands_new', methods: ['GET', 'POST'] )]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $brands = new Brands();

        $form = $this->createForm(BrandsType::class, $brands);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $brands = $form->getData();

            $manager->persist($brands);

            $manager->flush();

            $this->addFlash(
                'success',
                'Votre Marque a été créé avec succés'
            );    

            return $this->redirectToRoute('admin_brands_index');
        }

        return $this->render('Back_office/Brands/new.html.twig', [  
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/brands/edit/{id}', name: 'admin_brands_edit', methods: ['GET', 'POST'] )]
    public function edit(
        Brands $brands,
        Request $request,
        EntityManagerInterface $manager): Response 
    {
        
        $form = $this->createForm(BrandsType::class, $brands);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $brands = $form->getData();

            $manager->persist($brands);

            $manager->flush();

            $this->addFlash(
                'success',
                'Votre Marque a été modifié avec succés'
            );    

            return $this->redirectToRoute('admin_brands_index');
        }

        return $this->render('Back_office/Brands/edit.html.twig', [  
            'form' => $form->createView()
        ]);
    }

    #[Route('/admin/brands/delete/{id}', name: 'admin_brands_delete', methods: ['GET'] )]
    public function delete(
        EntityManagerInterface $manager, 
        Brands $brands, 
        Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$brands->getId(), $request->request->get('_token'))) {
            $manager->remove($brands);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre Marque a été supprimé avec succés'
            );    
        }
 
        return $this->redirectToRoute('admin_brands_index');
    }
}
