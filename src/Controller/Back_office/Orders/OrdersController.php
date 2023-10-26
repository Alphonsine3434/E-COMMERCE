<?php

namespace App\Controller\Back_office\Orders;

use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Repository\Back_office\Product\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class OrdersController extends AbstractController
{
    /**
     * Show Orders
     *
     * @param ProductRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    #[Route('admin/orders', name: 'admin_orders_index', methods: ['GET'] )]
    public function index(
        ProductRepository $repository, 
        PaginatorInterface $paginator, 
        Request $request , 
        EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $repository = $entityManager->getRepository(Orders::class);
        
        $orders = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        
        return $this->render('Back_office/Orders/index.html.twig', [
            'orders' => $orders
        ]);
    }

    #[Route('/add', name: 'add')]
    public function add(SessionInterface $sessionInterface, ProductRepository $productRepository, EntityManagerInterface $entityManager): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        $panier = $sessionInterface->get('panier', []);

        if($panier === []){
            $this->addFlash('message', 'Votre panier est vide');
        }

        //Créer détails commande
        $order = new Orders();

        //On rempli la commande
        $order->setUsers($this->getUser());
        $order->setReference(uniqid());

        foreach($panier as $item => $quantity){
            $orderDetails = new OrdersDetails();

            //Chercher produit
            $product = $productRepository->find($item);
            $price = $product->getPrice();

            //On crée détails commande
            $orderDetails->setProducts($product);
            $orderDetails->setPrice($price);
            $orderDetails->setQuantity($quantity);

            $order->addOrdersDetail($orderDetails);

        }

        $entityManager->persist($order);
        $entityManager->flush();

        $sessionInterface->remove('panier');

        $this->addFlash('message', 'commande créé avec succé');

        return $this->redirectToRoute('app_home_page');
    }
}
