<?php

namespace App\Controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(Request $request, UserRepository $userRepository): Response
    {
        $error = null;

        if($request->isMethod('POST')){
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            $user = $userRepository->findOneBy(['username' => $username]);
            if($user && password_verify($password, $user->getPassword())) {
                return $this->redirectToRoute('list');
            } else {
                $error = 'Wrong username or password';
            }
        }
        return $this->render('login.html.twig', [
            'error' => $error
        ]);
    }

    #[Route('/list', name: 'list')]
    public function list(): Response
    {
        return $this->render('list.html.twig');
    }
}
