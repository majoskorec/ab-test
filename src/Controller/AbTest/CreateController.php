<?php

declare(strict_types=1);

namespace App\Controller\AbTest;

use App\Entity\AbTest;
use App\Entity\User;
use App\Form\AbTestType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

final class CreateController extends AbstractController
{
    public function __construct(private Security $security, private EntityManagerInterface $entityManager)
    {

    }

    #[Route('/ab-test/create', name: 'app_ab_test_create')]
    public function __invoke(Request $request): Response
    {
        $user = $this->security->getUser();
        if (!$user instanceof User) {
            throw new UnauthorizedHttpException('unauthorized');
        }
        $abTest = new AbTest($user);
        $form = $this->createForm(AbTestType::class, $abTest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($abTest);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_ab_test_list');
        }

        return $this->render('ab_test/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
