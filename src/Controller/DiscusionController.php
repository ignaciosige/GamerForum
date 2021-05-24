<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Discusion;
use App\Entity\Comentario;
use App\Form\Type\DiscusionType;

class DiscusionController extends AbstractController
{
    public function foro()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $discusiones = $entityManager->getRepository(Discusion::class)->findAll();

        return $this->render('discusion/foro.html.twig', ['discusiones' => $discusiones]);
    }

    public function discusion(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $discusion = $entityManager->getRepository(Discusion::class)->find($id);

        $comentarios = $entityManager->getRepository(Comentario::class)->findAll();

        $comentario = new Comentario();

        $form = $this->createFormBuilder($comentario)
        ->add('texto', TextType::class)
        ->add('save', SubmitType::class,
            array('label' => 'Comentar'))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $comentario = $form->getData();

            $comentario->setAutor($this->getUser());

            $comentario->setDiscusion($discusion);

            $comentario->setFecha( new \DateTime( 'now' ));

            $entityManager->persist($comentario);

            $entityManager->flush();

            return $this->redirectToRoute('discusion', ['id' => $id]);
        }

        return $this->render('discusion/discusion.html.twig', [
            'form' => $form->createView(), 
            'discusion' => $discusion, 
            'comentarios' => $comentarios
            ]);
    }

    public function nuevaDiscusion(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $discusion = new Discusion();

        $form = $this->createForm(DiscusionType::class, $discusion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $discusion = $form->getData();

            $discusion->setCreador($this->getUser());
            
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($discusion);

            $entityManager->flush();

            return $this->redirectToRoute('foro');
        }

        return $this->render('discusion/formDiscusion.html.twig', ['form' => $form->createView()]);
    }

    public function eliminarDiscusion($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $discusion = $entityManager->getRepository(Discusion::class)->find($id);

        if (!$discusion){
            throw $this->createNotFoundException(
                'No existe ninguna discusion con id '.$id
            );
        }

        $entityManager->remove($discusion);

        $entityManager->flush();

        return $this->redirectToRoute('foro');
    }

    public function editarDiscusion(Request $request, $id)
    {
        $discusion = $entityManager->getRepository(Discusion::class)->find($id);

        if (!$discusion){
            throw $this->createNotFoundException(
                'No existe ninguna discusion con id '.$id
            );
        }

        $form = $this->createForm(DiscusionType::class, $discusion);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $discusion = $form->getData();

            $discusion->setCreador($this->getUser());
            
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            return $this->redirectToRoute('foro');
        }

        return $this->render('discusion/formDiscusion.html.twig', ['form' => $form->createView()]);
    }
}