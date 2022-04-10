<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

final class VerifyEmailController extends AbstractController
{
    public function __construct(
        private EmailVerifier $emailVerifier,
        private TranslatorInterface $translator,
        private UserRepository $userRepository
    ) {
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function __invoke(Request $request): Response
    {
        $id = $request->get('id');
        if (null === $id) {
            $this->addFlash('danger', 'Cannot find user for verification');

            return $this->redirectToRoute('app_login');
        }

        $user = $this->userRepository->find($id);
        if (null === $user) {
            $this->addFlash('danger', 'Cannot find user for verification');

            return $this->redirectToRoute('app_login');
        }

        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash(
                'verify_email_error',
                $this->translator->trans($exception->getReason(), [], 'VerifyEmailBundle'),
            );

            return $this->redirectToRoute('app_login');
        }

        $this->addFlash('success', 'Your email address has been verified. You can login.');

        return $this->redirectToRoute('app_login');
    }
}
