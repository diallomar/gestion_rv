<?php

namespace App\Controller;

use App\Entity\Patient;
use Symfony\Component\Mime\Email;
use App\Repository\PatientRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailController extends AbstractController
{
    /**
     * @Route("/mail/{id}", name="envoie_mail", methods={"GET","POST"})
     */
    public function mail(MailerInterface $mailer, Patient $patient): Response
    {
        $email = (new Email())
            ->from('oumardiallo22330000@gmail.com')
            ->to($patient->getEmail())
            ->subject('demande de rendez-vous')
            ->text('Bonjour, ' . $patient->getPrenom() . ' Votre demande a ete prise en compte toutefois vous être ' . $patient->getId() . ' éme sur la liste à la date demandé. Merci');

        $mailer->send($email);
        $this->addFlash('message', 'message envoy');
        return $this->render('mail/DemandeAccorde.twig', ['id' => $patient->getId(), 'prenom' => $patient->getPrenom(), 'nom' => $patient->getNom()]);
    }
}
