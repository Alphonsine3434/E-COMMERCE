<?php

namespace App\Controller\Back_office\HomePage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageBackController extends AbstractController
{
    #[Route('/admin', name: 'admin_homepage_index')]
    public function index(): Response
    {
        return $this->render('Back_office/Homepage_back/index.html.twig');
    }
}
