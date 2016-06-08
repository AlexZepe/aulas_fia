<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblCarreras
 */
class TblCarreras
{
    /**
     * @var integer
     */
    private $idcarrera;

    /**
     * @var string
     */
    private $nombrecarrera;

    /**
     * @var string
     */
    private $codigocarrera;

    /**
     * @var string
     */
    private $descripcioncarrera;

    /**
     * @var \AppBundle\Entity\TblEscuelas
     */
    private $idescuela;


    /**
     * Get idcarrera
     *
     * @return integer 
     */
    public function getIdcarrera()
    {
        return $this->idcarrera;
    }

    /**
     * Set nombrecarrera
     *
     * @param string $nombrecarrera
     * @return TblCarreras
     */
    public function setNombrecarrera($nombrecarrera)
    {
        $this->nombrecarrera = $nombrecarrera;

        return $this;
    }

    /**
     * Get nombrecarrera
     *
     * @return string 
     */
    public function getNombrecarrera()
    {
        return $this->nombrecarrera;
    }

    /**
     * Set codigocarrera
     *
     * @param string $codigocarrera
     * @return TblCarreras
     */
    public function setCodigocarrera($codigocarrera)
    {
        $this->codigocarrera = $codigocarrera;

        return $this;
    }

    /**
     * Get codigocarrera
     *
     * @return string 
     */
    public function getCodigocarrera()
    {
        return $this->codigocarrera;
    }

    /**
     * Set descripcioncarrera
     *
     * @param string $descripcioncarrera
     * @return TblCarreras
     */
    public function setDescripcioncarrera($descripcioncarrera)
    {
        $this->descripcioncarrera = $descripcioncarrera;

        return $this;
    }

    /**
     * Get descripcioncarrera
     *
     * @return string 
     */
    public function getDescripcioncarrera()
    {
        return $this->descripcioncarrera;
    }

    /**
     * Set idescuela
     *
     * @param \AppBundle\Entity\TblEscuelas $idescuela
     * @return TblCarreras
     */
    public function setIdescuela(\AppBundle\Entity\TblEscuelas $idescuela = null)
    {
        $this->idescuela = $idescuela;

        return $this;
    }

    /**
     * Get idescuela
     *
     * @return \AppBundle\Entity\TblEscuelas 
     */
    public function getIdescuela()
    {
        return $this->idescuela;
    }
	
	public function __toString()
    {
        return strval($this->nombrecarrera);
    }
}
