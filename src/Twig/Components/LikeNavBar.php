<?php

namespace App\Twig\Components;

use App\Repository\PlaylistRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent()]
final class LikeNavBar
{
    public function __construct(
        private PlaylistRepository $playlistRepository
    ) {
    }

    public function getPlaylists(): array
    {
        return $this->playlistRepository->findAll();
    }
}
