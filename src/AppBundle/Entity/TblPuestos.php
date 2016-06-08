<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblPuestos
 */
class TblPuestos
{
    /**
     * @var integer
     */
    private $idpuesto;

    /**
     * @var string
     */
    private $nombrepuesto;

    /**
     * @var string
     */
    private $descripcionpuesto;


    /**
     * Get idpuesto
     *
     * @return integer 
     */
    public function getIdpuesto()
    {
        return $this->idpuesto;
    }

    /**
     * Set nombrepuesto
     *
     * @param string $nombrepuesto
     * @return TblPuestos
     */
    public function setNombrepuesto($nombrepuesto)
    {
        $this->nombrepuesto = $nombrepuesto;

        return $this;
    }

    /**
     * Get nombrepuesto
     *
     * @return string 
     */
    public function getNombrepuesto()
    {
        return $this->nombrepuesto;
    }

    /**
     * Set descripcionpuesto
     *
     * @param string $descripcionpuesto
     * @return TblPuestos
     */
    public function setDescripcionpuesto($descripcionpuesto)
    {
        $this->descripcionpuesto = $descripcionpuesto;

        return $this;
    }

    /**
     * Get descripcionpuesto
     *
     * @return string 
     */
    public function getDescripcionpuesto()
    {
        return $this->descripcionpuesto;
    }
	
	public function __toString()
    {
        return strval($this->nombrepuesto);
    }
}
