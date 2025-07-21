<?php

namespace App\Controller;

use App\Entity\Main;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{



    #[Route('/main', name: 'Main')]
    public function main(EntityManagerInterface $manager, Request $request): Response
    {
        $error = null;

        if($request->isMethod('POST')) {
            $dziedzina_one= $request->request->get('dziedzina_one');
            $dziedzina_two= $request->request->get('dziedzina_two');
            $wojewodztwo= $request->request->get('wojewodztwo');

            $main = new Main();

            $main->setDziedzinaOne($dziedzina_one);
            $main->setDziedzinaTwo($dziedzina_two);
            $main->setWojewodztwo($wojewodztwo);

            $upload = $this->getParameter('kernel.project_dir').'/public/uploads';

            $logoFile = $request->files->get('logo');
            if ($logoFile) {
                $logoName = uniqid() . '.' . $logoFile->guessExtension();
                $logoFile->move($upload, $logoName);
                $main->setLogo($logoName);
            } else {
                $main->setLogo('pianki.jpg');
            }

            $tloFile = $request->files->get('tlo');
            if ($tloFile) {
                $tloName = uniqid() . '.' . $tloFile->guessExtension();
                $tloFile->move($upload, $tloName);
                $main->setTlo($tloName);
            } else {
                $main->setTlo('dom.jpg');
            }

            $manager->persist($main);
            $manager->flush();

        }
        return $this->render('main.html.twig', [
            'error' => $error,
        ]);
    }
}
