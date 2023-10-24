<?php

namespace App\Controller\Back_office\Supplier;

use App\Entity\Supplier;
use App\Form\SupplierType;
use App\Repository\SupplierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/supplier')]
class SupplierController extends AbstractController
{
    #[Route('/', name: 'supplier.index', methods: ['GET'])]
    public function index(SupplierRepository $supplierRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $suppliers = $paginator->paginate(
            $supplierRepository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('pages/supplier/index.html.twig', [
            'suppliers' => $supplierRepository->findAll(),
            'suppliers' => $suppliers
        ]);
    }

    #[Route('/new', name: 'supplier.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $supplier = new Supplier();

        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($supplier);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre produit a été créé avec succés'
            );   

            return $this->redirectToRoute('supplier.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/supplier/new.html.twig', [
            'supplier' => $supplier,
            'form' => $form,
        ]);
    }

    // #[Route('/{id}', name: 'supplier.show', methods: ['GET'])]
    // public function show(Supplier $supplier): Response
    // {
    //     return $this->render('pages/supplier/show.html.twig', [
    //         'supplier' => $supplier,
    //     ]);
    // }

    #[Route('/{id}/edit', name: 'supplier.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Supplier $supplier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre produit a été modifié avec succés'
            );   

            return $this->redirectToRoute('supplier.index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pages/supplier/edit.html.twig', [
            'supplier' => $supplier,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{id}/', name: 'supplier.delete', methods: ['POST'])]
    public function delete(Request $request, Supplier $supplier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$supplier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($supplier);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre produit a été supprimé avec succés'
            ); 
        }

        return $this->redirectToRoute('supplier.index', [], Response::HTTP_SEE_OTHER);
    }
}
