<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_homepage')]
final class HomepageController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->redirectToRoute('app_ab_test_list');
    }
}
