<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblActividades
 */
class TblActividades
{
    /**
     * @var integer
     */
    private $idactividad;

    /**
     * @var \AppBundle\Entity\TblCursos
     */
    private $idcurso;

    /**
     * @var \AppBundle\Entity\TblTiposActividades
     */
    private $idtipoactividad;


    /**
     * Get idactividad
     *
     * @return integer 
     */
    public function getIdactividad()
    {
        return $this->idactividad;
    }

    /**
     * Set idcurso
     *
     * @param \AppBundle\Entity\TblCursos $idcurso
     * @return TblActividades
     */
    public function setIdcurso(\AppBundle\Entity\TblCursos $idcurso = null)
    {
        $this->idcurso = $idcurso;

        return $this;
    }

    /**
     * Get idcurso
     *
     * @return \AppBundle\Entity\TblCursos 
     */
    public function getIdcurso()
    {
        return $this->idcurso;
    }

    /**
     * Set idtipoactividad
     *
     * @param \AppBundle\Entity\TblTiposActividades $idtipoactividad
     * @return TblActividades
     */
    public function setIdtipoactividad(\AppBundle\Entity\TblTiposActividades $idtipoactividad = null)
    {
        $this->idtipoactividad = $idtipoactividad;

        return $this;
    }

    /**
     * Get idtipoactividad
     *
     * @return \AppBundle\Entity\TblTiposActividades 
     */
    public function getIdtipoactividad()
    {
        return $this->idtipoactividad;
    }
	
	public function __toString()
    {
        return strval($this->idactividad);
    }
}
