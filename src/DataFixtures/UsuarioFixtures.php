<?php

namespace App\DataFixtures;

use App\Entity\Usuario;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsuarioFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // Usuario normal
        $usuario = new Usuario();
        $usuario->setNombreUsuario("Laura Moreno");
        $usuario->setEmail("laury28@gmail.com");
        $usuario->setFotoPerfil("defecto.jpg");
        $usuario->setFechaNacimiento( new \DateTime( 'now' ) );
        $usuario->setPassword($this->passwordEncoder->encodePassword(
            $usuario,
            'servilleta' // La contraseña
        ));
        $manager->persist($usuario);

        // Usuario administrador
        $usuario = new Usuario();
        $usuario->setNombreUsuario("Sylver1306");
        $usuario->setEmail("ignaciosilgen@gmail.com");
        $usuario->setFotoPerfil("defecto.jpg");
        $usuario->setFechaNacimiento( new \DateTime( 'now' ) );
        $usuario->setPassword($this->passwordEncoder->encodePassword(
            $usuario,
            'Sevilla12'
        ));
        // Le damos el rol de administrador (ROLE_ADMIN).
        $usuario->setRoles(array("ROLE_ADMIN"));
        $manager->persist($usuario);

        $manager->flush();
    }
}