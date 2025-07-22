<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Email;

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

        return $this->render('zlecenie/zlecenie.html.twig', [
            'error' => $error,
        ]);
    }

}
