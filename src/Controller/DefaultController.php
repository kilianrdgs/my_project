<?php

// Cette ligne indique que vous utilisez l'espace de noms "App\Controller"
namespace App\Controller;

// Ces deux lignes importent les classes nécessaires de Symfony
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Vous définissez une classe appelée DefaultController
class DefaultController {

    // Vous utilisez une annotation Symfony pour définir une route pour cette méthode
    // La route est associée à l'URL "/" et est nommée "app_index"
    #[Route("/", name: "app_index")]

    // Vous définissez une méthode publique appelée "index"
    public function index(){

        // Cette méthode renvoie une nouvelle instance de la classe Response avec le contenu 'bonjour'
        return new Response('bonjour');
    }

}
