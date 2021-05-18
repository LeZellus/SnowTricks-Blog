<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function index(): Response
    {
        $userAddress = $this->getUser()->getAddress();

        return $this->render('profil/index.html.twig', [
            'address' => $userAddress,
        ]);
    }
}
