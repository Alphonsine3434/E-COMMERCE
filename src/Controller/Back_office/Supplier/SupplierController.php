<?php

namespace App\Controller\Back_office\Supplier;

use App\Entity\Supplier;
use App\Form\Supplier\SupplierType;
use App\Repository\Back_office\Supplier\SupplierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class SupplierController extends AbstractController
{

    /**
     * This controller display all suppliers
     *
     * @param SupplierRepository $supplierRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/admin/supplier', name: 'admin_supplier_index', methods: ['GET'])]
    public function index(
        SupplierRepository $supplierRepository, 
        PaginatorInterface $paginator, 
        Request $request): Response
    {
        $suppliers = $paginator->paginate(
            $supplierRepository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('Back_office/Supplier/index.html.twig', [
            'suppliers' => $suppliers
        ]);
    }

    /**
     * This controller add new supplier
     *
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('/admin/supplier/new', name: 'admin_supplier_new', methods: ['GET', 'POST'])]
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
                'Votre Fournisseur a été créé avec succés'
            );   

            return $this->redirectToRoute('admin_supplier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back_office/Supplier/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller edit product
     *
     * @param Supplier $supplier
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response 
     */
    #[Route('/admin/supplier/edit/{id}', name: 'admin_supplier_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        Supplier $supplier, 
        EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SupplierType::class, $supplier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre Fournisseur a été modifié avec succés'
            );   

            return $this->redirectToRoute('admin_supplier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('Back_office/Supplier/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * This controller edit product
     *
     * @param Supplier $supplier
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response 
     */
    #[Route('/admin/supplier/delete/{id}', name: 'admin_supplier_delete', methods: ['POST'])]
    public function delete(
        Request $request, 
        Supplier $supplier, 
        EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$supplier->getId(), $request->request->get('_token'))) {
            $entityManager->remove($supplier);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre Fournisseur a été supprimé avec succés'
            ); 
        }

        return $this->redirectToRoute('admin_supplier_index', [], Response::HTTP_SEE_OTHER);
    }
}
