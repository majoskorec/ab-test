<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class LogoutController extends AbstractController
{
    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function __invoke(): void
    {
    }
}
