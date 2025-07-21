<?php

namespace App\Controller;

use App\Entity\Oferta;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class OfertaController extends AbstractController
{
    #[Route('/oferta', name: 'oferta')]
    public function oferta(EntityManagerInterface $manager, Request $request): Response
    {
        $error = null;

        if ($request->isMethod('POST')) {
            $oferta = new Oferta();

            $oferta->setTytul($request->get('tytul'));
            $oferta->setOpis($request->get('opis'));

            $manager->persist($oferta);
            $manager->flush();
        }

        return $this->render('oferta.html.twig', [
            'error' => $error,
        ]);
    }
}
