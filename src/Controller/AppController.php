<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Mensaje;
use App\Form\Type\MensajeType;

class AppController extends AbstractController
{
    private $entityManager;

    public function index()
    {
        return $this->render('gamerforum/index.html.twig');
    }

    public function contacto(MailerInterface $mailer, Request $request)
    {

        $mensaje = new Mensaje();

        $form = $this->createForm(MensajeType::class, $mensaje);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $mensaje = $form->getData();
            
            $email = (new Email())
            ->from($mensaje->getEmail())
            ->to('gamerforumes@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($mensaje->getAsunto())
            ->text($mensaje->getMensaje());

            $mailer->send($email);


        }

        return $this->render('gamerforum/contacto.html.twig', ['form' => $form->createView()]);    
    }
}