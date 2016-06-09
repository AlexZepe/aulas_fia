<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TblEmpleados 
 * @UniqueEntity("nombreempleado")
 */
class TblEmpleados
{
    /**
     * @var integer
     */
    private $idempleado;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $nombreempleado;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     */
    private $fechaingreso;

    /**
     * @var \AppBundle\Entity\TblPuestos
     * @Assert\NotBlank()
     */
    private $idpuesto;


    /**
     * Get idempleado
     *
     * @return integer 
     */
    public function getIdempleado()
    {
        return $this->idempleado;
    }

    /**
     * Set nombreempleado
     *
     * @param string $nombreempleado
     * @return TblEmpleados
     */
    public function setNombreempleado($nombreempleado)
    {
        $this->nombreempleado = $nombreempleado;

        return $this;
    }

    /**
     * Get nombreempleado
     *
     * @return string 
     */
    public function getNombreempleado()
    {
        return $this->nombreempleado;
    }

    /**
     * Set fechaingreso
     *
     * @param \DateTime $fechaingreso
     * @return TblEmpleados
     */
    public function setFechaingreso($fechaingreso)
    {
        $this->fechaingreso = $fechaingreso;

        return $this;
    }

    /**
     * Get fechaingreso
     *
     * @return \DateTime 
     */
    public function getFechaingreso()
    {
        return $this->fechaingreso;
    }

    /**
     * Set idpuesto
     *
     * @param \AppBundle\Entity\TblPuestos $idpuesto
     * @return TblEmpleados
     */
    public function setIdpuesto(\AppBundle\Entity\TblPuestos $idpuesto = null)
    {
        $this->idpuesto = $idpuesto;

        return $this;
    }

    /**
     * Get idpuesto
     *
     * @return \AppBundle\Entity\TblPuestos 
     */
    public function getIdpuesto()
    {
        return $this->idpuesto;
    }
	
	public function __toString()
    {
        return strval($this->nombreempleado);
    }
}
