<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Noticia;
use App\Form\Type\NoticiaType;

class NoticiaController extends AbstractController
{
    private $entityManager;

    public function noticias()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $noticias = $entityManager->getRepository(Noticia::class)->findAll();

        return $this->render('noticia/noticias.html.twig', ['noticias' => $noticias]);
    }

    public function noticia($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $noticia = $entityManager->getRepository(Noticia::class)->find($id);

        return $this->render('noticia/noticia.html.twig', ['noticia' => $noticia]);
    }

    public function nuevaNoticia(Request $request)
    {
        $noticia = new Noticia();

        $form = $this->createForm(NoticiaType::class, $noticia);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $noticia = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();

            // obtenemos todas las noticias
            $noticias = $entityManager->getRepository( Noticia::class )->findAll();

            // Recogemos el fichero
            $file = $form['imagen']->getData();

            // Sacamos la extensión del fichero
            $ext = $file->guessExtension();

            // Le ponemos un nombre al fichero
            $file_name = 'noticia'.( count( $noticias )+1 ).'.'.$ext;

            // Guardamos el fichero en el directorio uploads que estará en el directorio /web del framework
            $file->move( 'images', $file_name );

            // Establecemos el nombre de fichero en el atributo de la entidad
            $noticia->setImagen( $file_name );

            $noticia->setFecha( new \DateTime( 'now' ) );

            $entityManager->persist($noticia);

            $entityManager->flush();

            return $this->redirectToRoute('noticias');
        }

        return $this->render('noticia/formNoticia.html.twig', ['form' => $form->createView(), 'accion' => 'crear']);
    }

    public function eliminarNoticia($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $noticia = $entityManager->getRepository(Noticia::class)->find($id);

        if (!$noticia){
            throw $this->createNotFoundException(
                'No existe ninguna noticia con id '.$id
            );
        }

        $entityManager->remove($noticia);

        $entityManager->flush();

        return $this->redirectToRoute('noticias');
    }

    public function editarNoticia(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $noticia = $entityManager->getRepository(Noticia::class)->find($id);

        if (!$noticia){
            throw $this->createNotFoundException(
                'No existe ninguna noticia con id '.$id
            );
        }

        $form = $this->createForm(NoticiaType::class, $noticia);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $noticia = $form->getData();

            // obtenemos todas las noticias
            $noticias = $entityManager->getRepository( Noticia::class )->findAll();

            if($form['imagen']->getData()){
                // Recogemos el fichero
                $file = $form['imagen']->getData();

                // Sacamos la extensión del fichero
                $ext = $file->guessExtension();

                // Le ponemos un nombre al fichero
                $file_name = 'noticia'.( count( $noticias )+1 ).'.'.$ext;

                // Guardamos el fichero en el directorio uploads que estará en el directorio /web del framework
                if(file_exists('../public/images/'.$noticia->getImagen())){
                    unlink('../public/images/'.$noticia->getImagen());
                }
                $file->move( 'images', $file_name );

                // Establecemos el nombre de fichero en el atributo de la entidad
                $noticia->setImagen( $file_name );
            }

            $entityManager->flush();

            return $this->redirectToRoute('noticias');
        }

        return $this->render('noticia/formNoticia.html.twig', ['form' => $form->createView(), 'accion' => 'editar']);
    }
}