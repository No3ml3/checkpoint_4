<?php

namespace App\Controller;

use App\Entity\Music;
use App\Entity\User;
use App\Form\MusicType;
use App\Repository\MusicRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/musiques', name: 'app_')]
class AllMusicController extends AbstractController
{
    #[Route('/', name: 'all_music')]
    public function index(MusicRepository $musicRepository): Response
    {
        $musics = $musicRepository->findBy([], ['name'=> 'ASC']);

        return $this->render(
            'AllMusic/index.html.twig',
            [
                'musics' => $musics,
            ]
        );
    }

    #[Route('/{id}/favorite', methods: ['GET', 'POST'], name: 'favorite_music')]
    public function addToWatchlist(Music $music, UserRepository $userRepository): Response
    {
        if (!$music) {
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
        if (!$user->isInFavorite($music)) {
            $user->addFavorite($music);
        } else {
            $user->removeFavorite($music);
        }

        $userRepository->save($user, true);

        return $this->json([
            'isInWatchlist' => $user->isInFavorite($music)
        ]);
    }

    #[Route('/{id}/mesMusique', name: 'all_myMusic')]
    public function myMusic(User $user, MusicRepository $musicRepository): Response
    {
        $musics = $musicRepository->findBy(['user' => $user]);

        return $this->render(
            'AllMusic/myMusic.html.twig',
            [
                'musics' => $musics,
            ]
        );
    }

    #[Route('/{id}/mesLike', name: 'all_myLike')]
    public function myLike(User $user, MusicRepository $musicRepository): Response
    {
        $musics = $musicRepository->findAll();

        return $this->render(
            'AllMusic/myLike.html.twig',
            [
                'musics' => $musics,
            ]
        );
    }

    #[Route('/ajoute', name: 'music_add', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()) {
            $music = new Music();
            $form = $this->createForm(MusicType::class, $music);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $music->setUser($this->getUser());
                $entityManager->persist($music);
                $entityManager->flush();

                return $this->redirectToRoute('app_home', [], Response::HTTP_SEE_OTHER);
            }

            return $this->render('AllMusic/add.html.twig', [
                'music' => $music,
                'form' => $form,
            ]);
        } else {
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }
    }
}
