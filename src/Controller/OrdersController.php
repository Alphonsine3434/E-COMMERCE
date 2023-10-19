<?php

namespace App\Controller;

use App\Entity\Orders;
use App\Entity\OrdersDetails;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/orders', name: 'orders_')]
class OrdersController extends AbstractController
{
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
