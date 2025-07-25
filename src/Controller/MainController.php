<?php

namespace App\Controller;

use App\Entity\Main;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MainController extends AbstractController
{



    #[Route('/main', name: 'main')]
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
            }


            $tloFile = $request->files->get('tlo');
            if ($tloFile) {
                $tloName = uniqid() . '.' . $tloFile->guessExtension();
                $tloFile->move($upload, $tloName);
                $main->setTlo($tloName);
            }

            $manager->persist($main);
            $manager->flush();

        }
        return $this->render('main/main.html.twig', [
            'error' => $error,
        ]);
    }

    #[Route('/main/update/{id}', name: 'main_update')]
    public function updateMain(EntityManagerInterface $manager, Request $request, $id): Response
    {
        $main = $manager->getRepository(Main::class)->find($id);

        if (!$main) {
            throw $this->createNotFoundException("Main o ID $id nie istnieje.");
        }

        if ($request->isMethod('POST')) {
            $main->setDziedzinaOne($request->request->get('dziedzina_one'));
            $main->setDziedzinaTwo($request->request->get('dziedzina_two'));
            $main->setWojewodztwo($request->request->get('wojewodztwo'));

            $upload = $this->getParameter('kernel.project_dir').'/public/uploads';

            $logoFile = $request->files->get('logo');
            if ($logoFile) {
                $logoName = uniqid() . '.' . $logoFile->guessExtension();
                $logoFile->move($upload, $logoName);
                $main->setLogo($logoName);
            }

            $tloFile = $request->files->get('tlo');
            if ($tloFile) {
                $tloName = uniqid() . '.' . $tloFile->guessExtension();
                $tloFile->move($upload, $tloName);
                $main->setTlo($tloName);
            }

            $manager->persist($main);
            $manager->flush();
        }

        return $this->render('main/mainUpdate.html.twig', [
            'main' => $main,
        ]);
    }


    #[Route('/main_option', name: 'main_option')]
    public function option(EntityManagerInterface $manager): Response
    {
        $main = $manager->getRepository(Main::class)->findAll();

        return $this->render('main/optionMain.html.twig', [
            'main' => $main,
        ]);
    }

    #[Route('/api/main/list', name: 'main_list', methods: ['GET'])]
    public function list(EntityManagerInterface $manager, SerializerInterface $serializer): Response
    {
        $main = $manager->getRepository(Main::class)->findAll();

        $data = $serializer->normalize($main);
        return $this->json($data);
    }

}
