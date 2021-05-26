<?php

namespace App\Entity;

use App\Repository\JuegoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=JuegoRepository::class)
 */
class Juego
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $estado;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class, inversedBy="juegos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idJuego;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getIdJuego(): ?string
    {
        return $this->idJuego;
    }

    public function setIdJuego(string $idJuego): self
    {
        $this->idJuego = $idJuego;

        return $this;
    }
}
