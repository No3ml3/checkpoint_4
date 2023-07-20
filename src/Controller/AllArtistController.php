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
        $users = $userRepository->findTrueArtist();
        return $this->render('artist/index.html.twig', [
            'users' => $users,
        ]);
    }
    #[Route('/{id}/favorite', methods: ['GET', 'POST'], name: 'app_favorite_user')]
    public function addToWatchlist(User $likeUser, UserRepository $userRepository): Response
    {
        if (!$likeUser) {
            throw $this->createNotFoundException(
                'No music with this id found in music\'s table.'
            );
        }

        if (!$this->getUser()) {
            throw $this->createNotFoundException(
                'Your are not connected'
            );
        }

        /** @var \App\Entity\User */
        $user = $this->getUser();
        if (!$user->isInLikeByMe($likeUser)) {
            $user->addLikeByMe($likeUser);
        } else {
            $user->removeLikeByMe($likeUser);
        }

        $userRepository->save($user, true);

        return $this->json([
            'isInFavoriteArtist' => $user->isInLikeByMe($likeUser)
        ]);
    }

    #[Route('/artist/{id}', name: 'app_show_artist', methods: ['GET'])]
    public function showArtist(User $user): Response
    {
        return $this->render('artist/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/mesArtistsLike', name: 'app_likeArtist')]
    public function myLike(User $user): Response
    {
        return $this->render(
            'artist/myLike.html.twig'
        );
    }
}
