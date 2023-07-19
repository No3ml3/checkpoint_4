<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ProfilEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProfilController extends AbstractController
{
    #[Route('/profil/{id}', name: 'app_profil')]
    public function index(User $user): Response
    {
        return $this->render('profil/index.html.twig', [
            'user' => $user,
        ]);
    }
    #[Route('/profil/{id}/modifie', name: 'app_profil_modifie')]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProfilEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            /** @var \App\Entity\User */
            $user = $this->getUser();
            return $this->redirectToRoute('app_profil', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('profil/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}
