<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TblPerfil
 * @UniqueEntity("nombreperfil")
 */
class TblPerfil
{
    /**
     * @var integer
     */
    private $idperfil;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $nombreperfil;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var \DateTime
     */
    private $fechaalta;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $idusuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idusuario = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get idperfil
     *
     * @return integer 
     */
    public function getIdperfil()
    {
        return $this->idperfil;
    }

    /**
     * Set nombreperfil
     *
     * @param string $nombreperfil
     * @return TblPerfil
     */
    public function setNombreperfil($nombreperfil)
    {
        $this->nombreperfil = $nombreperfil;

        return $this;
    }

    /**
     * Get nombreperfil
     *
     * @return string 
     */
    public function getNombreperfil()
    {
        return $this->nombreperfil;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return TblPerfil
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaalta
     *
     * @param \DateTime $fechaalta
     * @return TblPerfil
     */
    public function setFechaalta($fechaalta)
    {
        $this->fechaalta = $fechaalta;

        return $this;
    }

    /**
     * Get fechaalta
     *
     * @return \DateTime 
     */
    public function getFechaalta()
    {
        return $this->fechaalta;
    }

    /**
     * Add idusuario
     *
     * @param \AppBundle\Entity\TblUsuarios $idusuario
     * @return TblPerfil
     */
    public function addIdusuario(\AppBundle\Entity\TblUsuarios $idusuario)
    {
        $this->idusuario[] = $idusuario;

        return $this;
    }

    /**
     * Remove idusuario
     *
     * @param \AppBundle\Entity\TblUsuarios $idusuario
     */
    public function removeIdusuario(\AppBundle\Entity\TblUsuarios $idusuario)
    {
        $this->idusuario->removeElement($idusuario);
    }

    /**
     * Get idusuario
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }
	
	public function __toString()
    {
        return strval($this->nombreperfil);
    }
}
