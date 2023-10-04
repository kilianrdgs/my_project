<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{

    #[Route('/admin', name: 'path_admin')]
    public function admin(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

}