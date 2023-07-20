<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\MusicRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllArtistController extends AbstractController
{
    #[Route('/artist', name: 'app_artist')]
    public function index(UserRepository $userRepository, MusicRepository $music): Response
    {
        $users = $userRepository->findBy([], ['speudo' => 'ASC']);
        return $this->render('artist/index.html.twig', [
            'users' => $users,
        ]);
    }
    #[Route('/artist/{id}', name: 'app_show_artist', methods: ['GET'])]
    public function showArtist(User $user): Response
    {
        return $this->render('artist/show.html.twig', [
            'user' => $user,
        ]);
    }
}
