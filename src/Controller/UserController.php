<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;


class UserController extends AbstractController
{
    #[Route('/admin/register', name: 'user_register', methods: ['POST'])]
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

    #[Route('/api/user/list', name: 'user_list', methods: ['GET'])]
    public function list(ManagerRegistry $registry, SerializerInterface $serializer): JsonResponse
    {
        $users = $registry->getRepository(User::class)->findAll();

        $data = $serializer->normalize($users);
        return $this->json($data);
    }

    #[Route('/api/user/{id}', name: 'user_show', methods: ['GET'])]
    public function id(EntityManagerInterface $manager, SerializerInterface $serializer, $id): JsonResponse
    {
        $user = $manager->getRepository(User::class)->find($id);

        $data = $serializer->normalize($user);
        return $this->json($data);
    }
}
