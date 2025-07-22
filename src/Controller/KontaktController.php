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

        return $this->render('kontakt/kontakt.html.twig', [
            'error' => $error,
        ]);
    }

    #[Route('/kontakt/update/{id}', name: 'kontakt_update')]
    public function update(Request $request, EntityManagerInterface $manager, $id): Response
    {
        $kontakt = $manager->getRepository(Kontakt::class)->find($id);
        if (!$kontakt) {
            throw $this->createNotFoundException("Kontakt o ID $id nie istnieje.");
        }

        if ($request->isMethod('POST')) {
            $kontakt->setNumerTel($request->request->get('numerTel'));
            $kontakt->setEmail($request->request->get('email'));
            $kontakt->setAdres($request->request->get('adres'));

            $manager->persist($kontakt);
            $manager->flush();
        }

        return $this->render('kontakt/kontaktUpdate.html.twig', [
            'kontakt' => $kontakt,
        ]);
    }

    #[Route('/kontakt_list', name: 'kontakt_option')]
    public function option(): Response
    {
        return $this->render('kontakt/optionKontakt.html.twig', []);
    }
}
