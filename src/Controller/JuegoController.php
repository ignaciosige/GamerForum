<?php
namespace App\Controller;

use App\Service\ApiJuegos;
use App\Entity\Juego;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class JuegoController extends AbstractController
{
    public function juegos(ApiJuegos $apiJuegos, $pagina)
    {
        $listaJuegos = $apiJuegos->getJuegos($pagina);

        return $this->render('juego/juegos.html.twig', ['juegos' => $listaJuegos, 'pagina' => $pagina]);
    }

    public function juego(ApiJuegos $apiJuegos, Request $request, $id)
    {
        $juego = $apiJuegos->getJuego($id);

        $estados=['Jugado', 'Pendiente', 'Jugando'];

        $entityManager = $this->getDoctrine()->getManager();
        
        $juegoUsuario = $entityManager->getRepository(Juego::class)->findOneBy(['usuario' => $this->getUser(),'idJuego' => $id]);

        if (!$juegoUsuario) {
            $juegoUsuario = new Juego();
        }

        $form = $this->createFormBuilder($juegoUsuario)
        ->add('estado', ChoiceType::class, ['choices' => $estados, 'choice_label' => function($choice, $key, $value) {return $value; }])
        ->add('save', SubmitType::class,
            array('label' => 'Guardar'))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $juegoUsuario = $form->getData();

            $juegoUsuario->setUsuario($this->getUser());

            $juegoUsuario->setIdJuego($id);

            $entityManager->persist($juegoUsuario);

            $entityManager->flush();

            return $this->redirectToRoute('juego', ['id' => $id]);
        }

        return $this->render('juego/juego.html.twig', ['juego' => $juego, 'id' => $id, 'form' => $form->createView()]);
    }

    public function checkJuego($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $juegoUsuario = $entityManager->getRepository(Juego::class)->findOneBy(['usuario' => $this->getUser(),'idJuego' => $id]);

        if (!$juegoUsuario) {
            return new Response('NO');
        }

        return new Response('OK');
    }

    public function eliminarJuego($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        $juegoUsuario = $entityManager->getRepository(Juego::class)->findOneBy(['usuario' => $this->getUser(),'idJuego' => $id]);

        if (!$juegoUsuario) {
            $juegoUsuario = new Juego();
        }

        $entityManager->remove($juegoUsuario);

        $entityManager->flush();

        return $this->redirectToRoute('juego',['id' => $id]);
    }
}