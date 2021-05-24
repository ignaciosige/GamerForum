<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Usuario;
use App\Form\Type\UsuarioType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

        $usuarios = $entityManager->getRepository(Noticia::class)->findAll();

        return $this->render('usuario/usuarios.html.twig', ['usuarios' => $usuarios]);
    }

    public function perfil($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $usuario = $entityManager->getRepository(Usuario::class)->find($id);

        return $this->render('usuario/perfil.html.twig', ['usuario' => $usuario]);
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

    public function eliminarUsuario(Request $request, $id)
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
}