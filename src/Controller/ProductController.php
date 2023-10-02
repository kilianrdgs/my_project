<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// Je déclare un espace de noms pour ce contrôleur Symfony.
#[Route('/product')]
class ProductController extends AbstractController
{
    // Je définis une route qui correspond à la page d'index des produits.
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        // Je rends un modèle Twig pour afficher la liste des produits.
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    // Je définis une route pour créer un nouveau produit.
    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Je crée une nouvelle instance de l'entité Product et un formulaire pour elle.
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, j'enregistre le nouveau produit.
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($product);
            $entityManager->flush();

            // Je redirige vers la page d'index des produits.
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        // Je rends le formulaire pour la création d'un nouveau produit.
        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    // Je définis une route pour afficher les détails d'un produit.
    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        // Je rends un modèle Twig pour afficher les détails du produit.
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    // Je définis une route pour éditer un produit existant.
    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        // Je crée un formulaire pour éditer le produit.
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        // Si le formulaire est soumis et valide, j'enregistre les modifications du produit.
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // Je redirige vers la page d'index des produits.
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        // Je rends le formulaire d'édition du produit.
        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    // Je définis une route pour supprimer un produit.
    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, EntityManagerInterface $entityManager): Response
    {
        // Je vérifie la validité du jeton CSRF pour éviter les attaques CSRF.
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager->remove($product);
            $entityManager->flush();
        }

        // Je redirige vers la page d'index des produits après la suppression.
        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }
}
