<?php

declare(strict_types=1);

namespace App\Controller\Admin\User;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Model\FromEmail;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

final class CreateController extends AbstractController
{
    public function __construct(
        private EmailVerifier $emailVerifier,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $userPasswordHasher,
        private FromEmail $fromEmail,
    ) {
    }

    /**
     * @throws Throwable
     */
    #[Route('/admin/user/create', name: 'app_admin_user_create')]
    public function __invoke(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $user->getEmail();
            if ($email === null) {
                throw new RuntimeException('missing user email');
            }
            $password = $this->randomPassword();
            $user->setPassword($this->userPasswordHasher->hashPassword($user, $password));

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation(
                'app_verify_email',
                $user,
                (new TemplatedEmail())
                    ->from(new Address($this->fromEmail->getEmail(), $this->fromEmail->getName()))
                    ->to($email)
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('admin/user/confirmation_email.html.twig'),
                $password,
            );

            return $this->redirectToRoute('app_admin_user_list');
        }

        return $this->render('admin/user/create.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    private function randomPassword(): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = random_int(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return implode($pass); //turn the array into a string
    }
}
