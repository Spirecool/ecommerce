<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/utilisateurs', name: 'admin_users_')]
class UsersController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/users/index.html.twig');
    }

    // #[Route('/{slug}', name: 'details')]
    // public function details(Products $product): Response
    // {
    //     // dd($product->getDescription());
    //     return $this->render('products/details.html.twig', compact('product'));
    // }
}