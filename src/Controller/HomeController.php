<?php

namespace App\Controller;

use App\Repository\MusicRepository;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MusicRepository $musicRepository, TypeRepository $typeRepository, UserRepository $userRepository): Response
    { 
        $musicsNew = $musicRepository->findBy([], ['id' => 'ASC'], 4);
        $musicsPopular = $musicRepository->findFavoriteMusic();
        $usersPopular = $userRepository->findFavoriteArtist(); 

        $typePopular = $typeRepository->findFavoriteType();
        return $this->render('Home/index.html.twig',[
            'musicsPopular' => $musicsPopular,
            'musicsNew' => $musicsNew,
            'typePopular' => $typePopular,
            'usersPopular' => $usersPopular,
    ]);
    }
}
