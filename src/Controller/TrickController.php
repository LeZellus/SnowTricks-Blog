<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use App\Service\FileUploaderServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class TrickController extends AbstractController
{
    #[Route('/trick', name: 'trick_index')]
    public function index(TrickRepository $trickRepository): Response
    {
        return $this->render('trick/index.html.twig', [
            'tricks' => $trickRepository->findAll(),
        ]);
    }

    #[Route('/trick/nouveau', name: 'trick_new')]
    public function new(Request $request, FileUploaderServiceInterface $fileUploaderService): Response
    {
        $trick = new Trick();
        $user = $this->getUser();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            if (!$user instanceof \App\Entity\User) {
                return new Response("FAUX");
            }

            $uploadedMainThumb = $form->get('mainThumb')->getData();
            $mainThumb = $fileUploaderService->uploadThumb($uploadedMainThumb, $trick, 'mainThumb');

            $trick->setMainThumb($mainThumb);
            $trick->setUser($user);

            $entityManager->persist($trick);
            $entityManager->flush();

            $this->addFlash("success", "Trick ajouté !");
            return $this->redirectToRoute('trick_index');
        }

        return $this->render('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/trick/{id}', name: 'trick_show')]
    public function show(Trick $trick, Request $request): Response
    {
        $user = $this->getUser();

        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {

            $comment->setTrick($trick);
            $comment->setUser($user);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('trick_show', ['id' => $trick->getId()]);
        }

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'formComment' => $commentForm->createView(),
        ]);
    }

    #[Route('/trick/edit/{id}', name: 'trick_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trick $trick, FileUploaderServiceInterface $fileUploaderService): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('mainThumb')->getData() != null) {
                $uploadedMainThumb = $form->get('mainThumb')->getData();
                $mainThumb = $fileUploaderService->uploadThumb($uploadedMainThumb, $user, 'mainThumb');

                $trick->setMainThumb($mainThumb);
            } else {
                $trick->setMainThumb($trick->getMainThumb());
            }

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('trick_index');
        }

        return $this->render('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/trick/supprimer/{id}', name: 'trick_delete')]
    public function delete(Request $request, Trick $trick): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($trick);
        $entityManager->flush();

        $this->addFlash("success", "Trick supprimé");
        return $this->redirectToRoute('trick_index');
    }
}