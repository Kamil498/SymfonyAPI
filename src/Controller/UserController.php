<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



#[Route('/admin')]
class UserController extends AbstractController
{
    #[Route('/register', name: 'user_register', methods: ['POST'])]
    public function register(ManagerRegistry $registry, Request $request, UserPasswordHasherInterface $hasher): JsonResponse
    {
        $em = $registry->getManager();
        $data = json_decode($request->getContent(), true);

        if (!isset($data['username'], $data['password'])) {
            return $this->json( 400);
        }

        $username = $data['username'];
        $password = $data['password'];

        $existingUser = $em->getRepository(User::class)->findOneBy(['username' => $username]);
        if ($existingUser) {
            return $this->json( 409);
        }

        $user = new User();
        $user->setUsername($username);

        $hashedPassword = $hasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $em->persist($user);
        $em->flush();

        return $this->json( 204);
    }
}
