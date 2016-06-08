<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblAulas
 */
class TblAulas
{
    /**
     * @var integer
     */
    private $idaula;

    /**
     * @var string
     */
    private $nombreaula;

    /**
     * @var integer
     */
    private $capacidadaula;

    /**
     * @var \AppBundle\Entity\TblEstadosAulas
     */
    private $idestadoaula;

    /**
     * @var \AppBundle\Entity\TblTiposAulas
     */
    private $idtipoaula;


    /**
     * Get idaula
     *
     * @return integer 
     */
    public function getIdaula()
    {
        return $this->idaula;
    }

    /**
     * Set nombreaula
     *
     * @param string $nombreaula
     * @return TblAulas
     */
    public function setNombreaula($nombreaula)
    {
        $this->nombreaula = $nombreaula;

        return $this;
    }

    /**
     * Get nombreaula
     *
     * @return string 
     */
    public function getNombreaula()
    {
        return $this->nombreaula;
    }

    /**
     * Set capacidadaula
     *
     * @param integer $capacidadaula
     * @return TblAulas
     */
    public function setCapacidadaula($capacidadaula)
    {
        $this->capacidadaula = $capacidadaula;

        return $this;
    }

    /**
     * Get capacidadaula
     *
     * @return integer 
     */
    public function getCapacidadaula()
    {
        return $this->capacidadaula;
    }

    /**
     * Set idestadoaula
     *
     * @param \AppBundle\Entity\TblEstadosAulas $idestadoaula
     * @return TblAulas
     */
    public function setIdestadoaula(\AppBundle\Entity\TblEstadosAulas $idestadoaula = null)
    {
        $this->idestadoaula = $idestadoaula;

        return $this;
    }

    /**
     * Get idestadoaula
     *
     * @return \AppBundle\Entity\TblEstadosAulas 
     */
    public function getIdestadoaula()
    {
        return $this->idestadoaula;
    }

    /**
     * Set idtipoaula
     *
     * @param \AppBundle\Entity\TblTiposAulas $idtipoaula
     * @return TblAulas
     */
    public function setIdtipoaula(\AppBundle\Entity\TblTiposAulas $idtipoaula = null)
    {
        $this->idtipoaula = $idtipoaula;

        return $this;
    }

    /**
     * Get idtipoaula
     *
     * @return \AppBundle\Entity\TblTiposAulas 
     */
    public function getIdtipoaula()
    {
        return $this->idtipoaula;
    }
	
	public function __toString()
    {
        return strval($this->nombreaula);
    }
}
