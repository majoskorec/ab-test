<?php

declare(strict_types=1);

namespace App\Controller\AbTest;

use App\Repository\AbTestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ab-test/list', name: 'app_ab_test_list')]
final class ListController extends AbstractController
{
    public function __construct(
        private readonly AbTestRepository $abTestRepository
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render('ab_test/list.html.twig', [
            'stats' => $this->abTestRepository->getStats(),
            'list' => $this->abTestRepository->findBy([], ['id' => 'DESC']),
        ]);
    }
}
