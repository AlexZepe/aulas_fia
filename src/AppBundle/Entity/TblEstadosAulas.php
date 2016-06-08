<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblEstadosAulas
 */
class TblEstadosAulas
{
    /**
     * @var integer
     */
    private $idestadoaula;

    /**
     * @var string
     */
    private $nombreestadoaula;

    /**
     * @var string
     */
    private $descripcionestadoaula;


    /**
     * Get idestadoaula
     *
     * @return integer 
     */
    public function getIdestadoaula()
    {
        return $this->idestadoaula;
    }

    /**
     * Set nombreestadoaula
     *
     * @param string $nombreestadoaula
     * @return TblEstadosAulas
     */
    public function setNombreestadoaula($nombreestadoaula)
    {
        $this->nombreestadoaula = $nombreestadoaula;

        return $this;
    }

    /**
     * Get nombreestadoaula
     *
     * @return string 
     */
    public function getNombreestadoaula()
    {
        return $this->nombreestadoaula;
    }

    /**
     * Set descripcionestadoaula
     *
     * @param string $descripcionestadoaula
     * @return TblEstadosAulas
     */
    public function setDescripcionestadoaula($descripcionestadoaula)
    {
        $this->descripcionestadoaula = $descripcionestadoaula;

        return $this;
    }

    /**
     * Get descripcionestadoaula
     *
     * @return string 
     */
    public function getDescripcionestadoaula()
    {
        return $this->descripcionestadoaula;
    }
	
	public function __toString()
    {
        return strval($this->nombreestadoaula);
    }
}
