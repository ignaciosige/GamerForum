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

    public function contacto(Request $request)
    {

        $mensaje = new Mensaje();

        $form = $this->createForm(MensajeType::class, $mensaje);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $mensaje = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($mensaje);

            $entityManager->flush();

            return $this->redirectToRoute('index');

        }

        return $this->render('gamerforum/contacto.html.twig', ['form' => $form->createView()]);    
    }

    public function mensajes()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $mensajes = $entityManager->getRepository(Mensaje::class)->findAll();

        return $this->render('mensaje/mensajes.html.twig', ['mensajes' => $mensajes]);
    }
}