<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblCursos
 */
class TblCursos
{
    /**
     * @var integer
     */
    private $idcurso;

    /**
     * @var string
     */
    private $nombrecurso;

    /**
     * @var \AppBundle\Entity\TblCiclos
     */
    private $idciclo;

    /**
     * @var \AppBundle\Entity\TblMaterias
     */
    private $idmateria;


    /**
     * Get idcurso
     *
     * @return integer 
     */
    public function getIdcurso()
    {
        return $this->idcurso;
    }

    /**
     * Set nombrecurso
     *
     * @param string $nombrecurso
     * @return TblCursos
     */
    public function setNombrecurso($nombrecurso)
    {
        $this->nombrecurso = $nombrecurso;

        return $this;
    }

    /**
     * Get nombrecurso
     *
     * @return string 
     */
    public function getNombrecurso()
    {
        return $this->nombrecurso;
    }

    /**
     * Set idciclo
     *
     * @param \AppBundle\Entity\TblCiclos $idciclo
     * @return TblCursos
     */
    public function setIdciclo(\AppBundle\Entity\TblCiclos $idciclo = null)
    {
        $this->idciclo = $idciclo;

        return $this;
    }

    /**
     * Get idciclo
     *
     * @return \AppBundle\Entity\TblCiclos 
     */
    public function getIdciclo()
    {
        return $this->idciclo;
    }

    /**
     * Set idmateria
     *
     * @param \AppBundle\Entity\TblMaterias $idmateria
     * @return TblCursos
     */
    public function setIdmateria(\AppBundle\Entity\TblMaterias $idmateria = null)
    {
        $this->idmateria = $idmateria;

        return $this;
    }

    /**
     * Get idmateria
     *
     * @return \AppBundle\Entity\TblMaterias 
     */
    public function getIdmateria()
    {
        return $this->idmateria;
    }
	
	public function __toString()
    {
        return strval($this->nombrecurso);
    }
	
	
}
