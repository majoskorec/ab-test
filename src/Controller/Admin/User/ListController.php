<?php

declare(strict_types=1);

namespace App\Controller\Admin\User;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user/list', name: 'app_admin_user_list')]
final class ListController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository,
    ) {
    }

    public function __invoke(): Response
    {
        return $this->render('admin/user/list.html.twig', [
            'list' => $this->userRepository->findBy([], ['id' => 'DESC']),
        ]);
    }
}
