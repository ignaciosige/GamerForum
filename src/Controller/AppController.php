<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Mensaje;
use App\Form\Type\MensajeType;

class AppController extends AbstractController
{
    public function index()
    {
        return $this->render('gamerforum/index.html.twig');
    }

    public function contacto( \Swift_Mailer $mailer, Request $request)
    {

        $mensaje = new Mensaje();

        $form = $this->createForm(MensajeType::class, $mensaje);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $mensaje = $form->getData();

            $email = (new \Swift_Message($mensaje->getAsunto()))
                    ->setFrom($mensaje->getEmail())
                    ->setTo('gamerforumes@gmail.com')
                    ->setBody($mensaje->getEmail().":\n\n".$mensaje->getTexto());

            $mailer->send($email);

        }

        return $this->render('gamerforum/contacto.html.twig', ['form' => $form->createView()]);    
    }
}