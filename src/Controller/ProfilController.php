<?php

namespace App\Controller;

use App\Form\AddressType;
use App\Form\ProfilThumbType;
use App\Form\UserInfoType;
use App\Service\FileUploaderServiceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil_index')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig');
    }

    #[Route('/profil/editer', name: 'profil_edit')]
    public function edit(Request $request, FileUploaderServiceInterface $fileUploaderService): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $address = $user->getAddress();
        $thumb = $user->getThumb();

        $formUpdateUser = $this->createForm(UserInfoType::class, $user);
        $formUpdateUser->handleRequest($request);

        $formUpdateAddress = $this->createForm(AddressType::class, $address);
        $formUpdateAddress->handleRequest($request);

        $formUpdateThumb = $this->createForm(ProfilThumbType::class, $thumb);
        $formUpdateThumb->handleRequest($request);

        if ($formUpdateUser->isSubmitted() && $formUpdateUser->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre profil à été modifié !');
            return $this->redirectToRoute('profil_index');
        }

        if ($formUpdateAddress->isSubmitted() && $formUpdateAddress->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Votre adresse à été modifiée !');
            return $this->redirectToRoute('profil_index');
        }

        if ($formUpdateThumb->isSubmitted() && $formUpdateThumb->isValid()) {
            $uploadedFile = $formUpdateThumb->get('thumb')->getData();

            if($uploadedFile){
                $thumb = $fileUploaderService->profilThumb($uploadedFile, $user);
            }

            $user->setThumb($thumb);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'La photo de profil a été modifiée');
            return $this->redirectToRoute("profil_index");
        }

        return $this->render('profil/edit.html.twig', array(
            'formUpdateUser' => $formUpdateUser->createView(),
            'formUpdateAddress' => $formUpdateAddress->createView(),
            'formUpdateThumb' => $formUpdateThumb->createView(),
        ));
    }


    /**
     * @return Response
     */
    #[Route('/profil/supprimer', name: 'profil_remove')]
    public function remove(): Response
    {
        $user = $this->getUser();

        if ($user) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();

            $session = new Session();
            $session->invalidate();

            return $this->redirectToRoute('app_logout');
        }

        return $this->redirectToRoute("app_login");
    }
}
