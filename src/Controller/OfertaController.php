<?php

namespace App\Controller;

use App\Entity\Oferta;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

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

        return $this->render('oferta/oferta.html.twig', [
            'error' => $error,
        ]);
    }

    #[Route('/oferta/update/{id}', name: 'oferta_update')]
    public function update(EntityManagerInterface $manager, Request $request, $id): Response
    {
        $oferta = $manager->getRepository(Oferta::class)->find($id);

        if($request->isMethod('POST')) {
            $oferta->setTytul($request->get('tytul'));
            $oferta->setOpis($request->get('opis'));

            $manager->persist($oferta);
            $manager->flush();
        }

        return $this->render('oferta/ofertaUpdate.html.twig', [
            'oferta' => $oferta,
        ]);

    }


    #[Route('/oferta_option', name: 'oferta_option')]
    public function ofertaOption(EntityManagerInterface $manager): Response
    {
        $oferts = $manager->getRepository(Oferta::class)->findAll();

        return $this->render('oferta/optionOferta.html.twig', [
            'oferts' => $oferts,
        ]);
    }

    #[Route('/api/oferta/list', name: 'oferta_list', methods: ['GET'])]
    public function list(EntityManagerInterface $manager, SerializerInterface $serializer): Response
    {
        $oferta = $manager->getRepository(Oferta::class)->findAll();

        $data  = $serializer->normalize($oferta);
        return $this->json($data);
    }

    #[Route('/api/oferta/{id}', name: 'main_id', methods: ['GET'])]
    public function id(EntityManagerInterface $manager,SerializerInterface $serializer, $id): Response
    {
        $oferta = $manager->getRepository(Oferta::class)->find($id);

        $data = $serializer->normalize($oferta);
        return $this->json($data);
    }
}
