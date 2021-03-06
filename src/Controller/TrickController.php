<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use App\Service\FileUploaderServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

            foreach ($trick->getThumbs() as $thumb) {
                $thumb = $fileUploaderService->saveImage($thumb);
                $thumb->setTrick($trick);
                $thumb->setUser($user);

                $entityManager->persist($thumb);
            }

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
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('thumbs')->getData();
            $mainThumb = $fileUploaderService->uploadThumb($uploadedFile, $trick, 'mainThumb');
            $trick->setMainThumb($mainThumb);

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