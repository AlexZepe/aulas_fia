<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblEmpleados
 */
class TblEmpleados
{
    /**
     * @var integer
     */
    private $idempleado;

    /**
     * @var string
     */
    private $nombreempleado;

    /**
     * @var \DateTime
     */
    private $fechaingreso;

    /**
     * @var \AppBundle\Entity\TblPuestos
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
