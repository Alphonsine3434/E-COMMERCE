<?php

namespace App\Controller\Back_office\Authentification\Register;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterBackController extends AbstractController
{
    #[Route('/admin/register', name: 'admin_register_index')]
    public function index(): Response
    {
        return $this->render('Back_office/Authentification/Register/register.html.twig');
    }
}
