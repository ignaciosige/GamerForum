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
     * @ORM\Column(type="boolean")
     */
    private $jugado;

    /**
     * @ORM\Column(type="boolean")
     */
    private $jugando;

    /**
     * @ORM\Column(type="boolean")
     */
    private $pendiente;

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

    public function getJugado(): ?bool
    {
        return $this->jugado;
    }

    public function setJugado(bool $jugado): self
    {
        $this->jugado = $jugado;

        return $this;
    }

    public function getJugando(): ?bool
    {
        return $this->jugando;
    }

    public function setJugando(bool $jugando): self
    {
        $this->jugando = $jugando;

        return $this;
    }

    public function getPendiente(): ?bool
    {
        return $this->pendiente;
    }

    public function setPendiente(bool $pendiente): self
    {
        $this->pendiente = $pendiente;

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
