<?php

namespace App\Controller\Back_office\Authentification\Login;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginBackController extends AbstractController
{
    #[Route('/admin/login', name: 'app_login_back')]
    public function index(): Response
    {
        return $this->render('Back_office/Authentification/Login/login.html.twig');
    }
}
