<?php

namespace App\Controller;

use App\Entity\Type;
use App\Repository\TypeRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllTypeController extends AbstractController
{
    #[Route('/Genre', name: 'app_type')]
    public function index(TypeRepository $typeRepository): Response
    {
        $types = $typeRepository->findBy([], ['name' => 'ASC']);
        return $this->render('allType/index.html.twig', [
            'types' => $types,
        ]);
    }
    #[Route('Genre/{id}/favorite', methods: ['GET', 'POST'], name: 'app_favorite_type')]
    public function addToFavoriteType(Type $type, UserRepository $userRepository): Response
    {
        if (!$type) {
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
        if (!$user->isInFavoriteType($type)) {
            $user->addFavoriteType($type);
        } else {
            $user->removeFavoriteType($type);
        }

        $userRepository->save($user, true);

        return $this->json([
            'isInFavoriteType' => $user->isInFavoriteType($type)
        ]);
    }
}
