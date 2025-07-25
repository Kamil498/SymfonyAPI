<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Serializer\SerializerInterface;

class OrderController extends AbstractController
{

    #[Route('/order', name: 'zlecenie')]
    public function zlecenie(Request $request, EntityManagerInterface $manager, MailerInterface $mailer): Response
    {
        $error = null;
        if ($request->isMethod('POST')) {


            $imieNazwisko = $request->get('imie_nazwisko');
            $email = $request->get('email');
            $numerTel = $request->get('numer_tel');
            $content = $request->get('content');
            $status = $request->get('status') ?? 0;

            $order = new Order();

            $order->setImieNazwisko($imieNazwisko);
            $order->setEmail($email);
            $order->setNumerTel($numerTel);
            $order->setContent($content);
            $order->setStatus($status);

            $manager->persist($order);
            $manager->flush();

            $odbiorca = 'kamilbialy08@wp.pl';

            $emailMessage = (new Email())
                ->from($email)   // nadawca z formularza
                ->to($odbiorca)  // stały odbiorca
                ->subject('Nowe zlecenie od ' . $imieNazwisko)
                ->text("Imię i nazwisko: $imieNazwisko\nEmail: $email\nNumer telefonu: $numerTel\nOpis: $content");

            try {
                $mailer->send($emailMessage);
            } catch (\Exception $e) {
                $error = "Nie udało się wysłać maila: " . $e->getMessage();
            }

        }

        return $this->render('zlecenie/optionZlecenie.html.twig', [
            'error' => $error,
        ]);
    }


    #[Route('/zlecenie/list', name: 'zlecenie_option')]
    public function zlecenieList(EntityManagerInterface $manager): Response
    {
        $zlecenie = $manager->getRepository(Order::class)->findAll();

        return $this->render('zlecenie/optionZlecenie.html.twig', [
            'zlecenie' => $zlecenie,
        ]);
    }


    #[Route('/api/zlecenie/list', name: 'zlecenie_list', methods: ['GET'])]
    public function list(EntityManagerInterface $manager, SerializerInterface $serializer): JsonResponse
    {
        $zlecenie = $manager->getRepository(Order::class)->findAll();

        $data = $serializer->normalize($zlecenie);
        return $this->json($data);
    }



    #[Route('/api/zlecenie/{id}', name: 'zlecenie_id', methods: ['GET'])]
    public function zlecenieId(EntityManagerInterface $manager, SerializerInterface $serializer, $id): JsonResponse
    {
        $zlecenia = $manager->getRepository(Order::class)->find($id);

        $data = $serializer->normalize($zlecenia);
        return $this->json($data);

    }



    #[Route('/zlecenie/{id}', name: 'zlecenie_show')]
    public function zlecenieShow($id, EntityManagerInterface $manager, Request $request): Response
    {
        $zlecenie = $manager->getRepository(Order::class)->find($id);

        if($request->isMethod('POST')) {
            $zlecenie->setImieNazwisko($request->get('imie_nazwisko'));
            $zlecenie->setEmail($request->get('email'));
            $zlecenie->setNumerTel($request->get('numer_tel'));
            $zlecenie->setContent($request->get('content'));
            $zlecenie->setStatus($request->get('status'));

            $manager->persist($zlecenie);
            $manager->flush();
        }


        return $this->render('zlecenie/zlecenieShow.html.twig', [
            'zlecenie' => $zlecenie,
        ]);
    }


}
