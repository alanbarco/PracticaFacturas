<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tipotrabajo
 *
 * @ORM\Table(name="tipotrabajo")
 * @ORM\Entity(repositoryClass="App\Repository\TipoRepository")
 */
class Tipotrabajo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_tipo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tipotrabajo_id_tipo_seq", allocationSize=1, initialValue=1)
     */
    private $idTipo;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=150, nullable=false)
     */
    private $descripcion;

    /**
     * @var float|null
     *
     * @ORM\Column(name="valorhora", type="float", precision=10, scale=0, nullable=true)
     */
    private $valorhora;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=1, nullable=false)
     */
    private $estado;

    public function getIdTipo(): ?int
    {
        return $this->idTipo;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getValorhora(): ?float
    {
        return $this->valorhora;
    }

    public function setValorhora(?float $valorhora): self
    {
        $this->valorhora = $valorhora;

        return $this;
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


}
