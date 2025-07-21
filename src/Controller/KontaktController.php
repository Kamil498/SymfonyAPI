<?php

namespace App\Controller;

use App\Entity\Kontakt;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class KontaktController extends AbstractController
{
    #[Route('/kontakt', name: 'kontakt')]
    public function kontakt( EntityManagerInterface $manager, Request $request): Response
    {
        $error = null;

        if ($request->isMethod('POST')) {

            $kontakt = new Kontakt();

           $kontakt->setNumerTel($request->get('numerTel'));
           $kontakt->setEmail($request->get('email'));
           $kontakt->setAdres($request->get('adres'));

           $manager->persist($kontakt);
           $manager->flush();

        }

        return $this->render('kontakt.html.twig', [
            'error' => $error,
        ]);
    }

    public function update(Request $request, EntityManagerInterface $manager): Response
    {
        $error = null;

        $id = $request->request->get('id');
        $kontakt = $manager->getRepository(Kontakt::class)->find($id);

        $kontakt->setNumerTel($request->get('numerTel'));
        $kontakt->setEmail($request->get('email'));
        $kontakt->setAdres($request->get('adres'));

        $manager->persist($kontakt);
        $manager->flush();

        return $this->render('kontakt.html.twig', [
            'error' => $error,
            'kontakt' => null
        ]);
    }
}
