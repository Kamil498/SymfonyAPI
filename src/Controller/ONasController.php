<?php

namespace App\Controller;

use App\Entity\ONas;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ONasController extends AbstractController
{
    #[Route('/onas', name: 'onas')]
    public function onas(EntityManagerInterface $manager, Request $request): Response
    {
        $error = null;

       if($request->isMethod('POST')) {
           $tytul = $request->request->get('tytul');
           $opis = $request->request->get('opis');


           $onas = new ONas();

           $onas->setTytul($tytul);
           $onas->setOpis($opis);

           $manager->persist($onas);
           $manager->flush();
       }


        return $this->render('onas/onas.html.twig', [
            'error' => $error
        ]);
    }

    #[Route('/onas_option', name: 'onas_option')]
    public function option(): Response
    {
        return $this->render('onas/optionOnas.html.twig', []);
    }
}
