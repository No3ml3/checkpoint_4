<?php

namespace App\Controller;

use App\Repository\MusicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MusicRepository $musicRepository): Response
    { 
        $musics = $musicRepository->findFavoriteMusic();
        return $this->render('Home/index.html.twig',[
            'musics' => $musics,
    ]);
    }
}
