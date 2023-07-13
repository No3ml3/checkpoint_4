<?php

namespace App\Controller;

use App\Entity\Music;
use App\Repository\MusicRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/musiques', name: 'app_')]
class AllMusicController extends AbstractController
{
    #[Route('/', name: 'all_music')]
    public function index(MusicRepository $musicRepository): Response
    {
        $musics = $musicRepository->findAll();

        return $this->render('AllMusic/index.html.twig', 
    [
        'musics' => $musics,
    ]);
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
}
