<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Usuario;
use App\Entity\Juego;
use App\Form\Type\UsuarioType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UsuarioController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function usuarios()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $usuarios = $entityManager->getRepository(Usuario::class)->findAll();

        return $this->render('usuario/usuarios.html.twig', ['usuarios' => $usuarios]);
    }

    public function perfil(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $usuario = $entityManager->getRepository(Usuario::class)->find($id);

        $juegos = $entityManager->getRepository(Juego::class)->findBy(['usuario' => $usuario]);

        $form = $this->createFormBuilder($usuario)
        ->add('fotoPerfil', FileType::class, ['mapped' => false])
        ->add('save', SubmitType::class,
            array('label' => 'Guardar'))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $form['fotoPerfil']->getData()) {

            // Recogemos el fichero
            $file = $form['fotoPerfil']->getData();

            // Sacamos la extensión del fichero
            $ext = $file->guessExtension();

            // Le ponemos un nombre al fichero
            $file_name = 'usuario'.$id.'perfil.'.$ext;

            // Guardamos el fichero en el directorio uploads que estará en el directorio /web del framework
            if ($usuario->getFotoPerfil()) {
                if(file_exists('../public/images/'.$usuario->getFotoPerfil())){
                    unlink('../public/images/'.$usuario->getFotoPerfil());
                }
            }
            $file->move( 'images', $file_name );

            // Establecemos el nombre de fichero en el atributo de la entidad
            $usuario->setFotoPerfil( $file_name );

            $entityManager->flush();
    
            return $this->redirectToRoute('perfil', ['id' => $id]);
            
        }

        return $this->render('usuario/perfil.html.twig', ['usuario' => $usuario, 'juegos' => $juegos, 'form' => $form->createView()]);
    }

    public function registro(Request $request)
    {
        $usuario = new Usuario();

        $form = $this->createForm(UsuarioType::class, $usuario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $usuario = $form->getData();

            $usuario->setPassword($this->passwordEncoder->encodePassword(
                $usuario,
                $usuario->getPassword()
            ));

            $usuario->setFotoPerfil('defecto.jpg');
            
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($usuario);

            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('usuario/registro.html.twig', ['form' => $form->createView()]);
    }

    public function editarUsuario(Request $request, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $usuario = $entityManager->getRepository(Usuario::class)->find($id);

        if (!$usuario){
            throw $this->createNotFoundException(
                'No existe ningun usuario con id '.$id
            );
        }

        $form = $this->createForm(UsuarioType::class, $usuario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $usuario = $form->getData();

            $usuario->setPassword($this->passwordEncoder->encodePassword(
                $usuario,
                $usuario->getPassword()
            ));

            $entityManager->flush();

            return $this->redirectToRoute('perfil', ['id' => $id]);
        }

        return $this->render('usuario/registro.html.twig', ['form' => $form->createView()]);
    }

    public function eliminarUsuario($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $usuario = $entityManager->getRepository(Usuario::class)->find($id);

        if (!$usuario){
            throw $this->createNotFoundException(
                'No existe ningun usuario con id '.$id
            );
        }

        $entityManager->remove($usuario);

        $entityManager->flush();

        return $this->redirectToRoute('index');
    }

    public function checkUsuarioNombre($nombreUsuario)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(['nombreUsuario' => $nombreUsuario]);

        if ($usuario) {
            return new Response('KO');
        }

        return new Response('OK');
    }

    public function checkUsuarioEmail($email)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $usuario = $entityManager->getRepository(Usuario::class)->findBy(['email' => $email]);

        if ($usuario) {
            return new Response('KO');
        }

        return new Response('OK');
    }
}