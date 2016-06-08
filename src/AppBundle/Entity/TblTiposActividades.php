<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblTiposActividades
 */
class TblTiposActividades
{
    /**
     * @var integer
     */
    private $idtipoactividad;

    /**
     * @var string
     */
    private $nombretipoactividad;

    /**
     * @var string
     */
    private $descripciontipoactividad;


    /**
     * Get idtipoactividad
     *
     * @return integer 
     */
    public function getIdtipoactividad()
    {
        return $this->idtipoactividad;
    }

    /**
     * Set nombretipoactividad
     *
     * @param string $nombretipoactividad
     * @return TblTiposActividades
     */
    public function setNombretipoactividad($nombretipoactividad)
    {
        $this->nombretipoactividad = $nombretipoactividad;

        return $this;
    }

    /**
     * Get nombretipoactividad
     *
     * @return string 
     */
    public function getNombretipoactividad()
    {
        return $this->nombretipoactividad;
    }

    /**
     * Set descripciontipoactividad
     *
     * @param string $descripciontipoactividad
     * @return TblTiposActividades
     */
    public function setDescripciontipoactividad($descripciontipoactividad)
    {
        $this->descripciontipoactividad = $descripciontipoactividad;

        return $this;
    }

    /**
     * Get descripciontipoactividad
     *
     * @return string 
     */
    public function getDescripciontipoactividad()
    {
        return $this->descripciontipoactividad;
    }
	
	public function __toString()
    {
        return strval($this->nombretipoactividad);
    }
}
