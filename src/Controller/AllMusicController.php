<?php

namespace App\Controller;

use App\Repository\MusicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllMusicController extends AbstractController
{
    #[Route('/musiques', name: 'app_all_music')]
    public function index(MusicRepository $musicRepository): Response
    {
        $musics = $musicRepository->findAll();

        return $this->render('AllMusic/index.html.twig', 
    [
        'musics' => $musics,
    ]);
    }
}
