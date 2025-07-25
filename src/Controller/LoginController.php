<?php

namespace App\Controller;


use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(Request $request, UserRepository $userRepository, SessionInterface $session): Response
    {
        $error = null;

        if($request->isMethod('POST')){
            $username = $request->request->get('username');
            $password = $request->request->get('password');

            $user = $userRepository->findOneBy(['username' => $username]);
            if($user && password_verify($password, $user->getPassword())) {

                $session->set('user_id', $user->getId());
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
    public function list(SessionInterface $session): Response
    {
        if (!$session->has('user_id')) {
            return $this->redirectToRoute('login');
        }

        return $this->render('list.html.twig');
    }

}
