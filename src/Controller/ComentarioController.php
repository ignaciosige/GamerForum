<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Discusion;
use App\Entity\Comentario;
use App\Form\Type\DiscusionType;

class ComentarioController extends AbstractController
{
    public function eliminarComentario($id, $idDiscusion)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $comentario = $entityManager->getRepository(Comentario::class)->find($id);

        if (!$comentario){
            throw $this->createNotFoundException(
                'No existe ningun comentario con id '.$id
            );
        }

        $entityManager->remove($comentario);

        $entityManager->flush();

        return $this->redirectToRoute('discusion', ['id' => $idDiscusion]);
    }

    public function editarComentario(Request $request, $id, $idDiscusion)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $comentario = $entityManager->getRepository(Comentario::class)->find($id);

        if (!$comentario){
            throw $this->createNotFoundException(
                'No existe ningun comentario con id '.$id
            );
        }

        $form = $this->createFormBuilder($comentario)
        ->add('texto', TextType::class)
        ->add('save', SubmitType::class,
            array('label' => 'Confirmar'))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $comentario = $form->getData();

            $entityManager->flush();

            return $this->redirectToRoute('discusion', ['id' => $idDiscusion]);
        }

        return $this->render('comentario/formComentario.html.twig', ['form' => $form->createView()]);
    }
}