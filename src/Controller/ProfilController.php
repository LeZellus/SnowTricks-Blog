<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Thumb;
use App\Form\AddressType;
use App\Form\ProfilThumbType;
use App\Form\UserInfoType;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil_index')]
    public function index(): Response
    {
        return $this->render('profil/index.html.twig');
    }

    #[Route('/profil/editer', name: 'profil_edit')]
    public function edit(Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $address = $user->getAddress();
        $thumb = $user->getThumb();

        /* Manage user info */
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
            $thumb = new Thumb();
            $file = $formUpdateThumb->get('thumb')->getData();
            $newFileName = uniqid() . '.' . $file->guessExtension();

            try {
                $file->move(
                    $this->getParameter('profil_thumb'). $user->getPseudonyme(),
                    $newFileName
                );

                $thumb->setPath($newFileName);
                $thumb->setOldName(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                $thumb->setNewName($newFileName);

            } catch (FileException $e) {
                return new Response($e->getMessage());
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
}
