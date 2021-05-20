<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function index(TrickRepository $repository): Response
    {
        $tricks = $repository->findAll();

        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
        ]);
    }
}
