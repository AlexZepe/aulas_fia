<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblCursosDocentes
 */
class TblCursosDocentes
{
    /**
     * @var integer
     */
    private $idcursodocente;

    /**
     * @var string
     */
    private $cargo;

    /**
     * @var \AppBundle\Entity\TblCursos
     */
    private $idcurso;

    /**
     * @var \AppBundle\Entity\TblEmpleados
     */
    private $idempleado;


    /**
     * Get idcursodocente
     *
     * @return integer 
     */
    public function getIdcursodocente()
    {
        return $this->idcursodocente;
    }

    /**
     * Set cargo
     *
     * @param string $cargo
     * @return TblCursosDocentes
     */
    public function setCargo($cargo)
    {
        $this->cargo = $cargo;

        return $this;
    }

    /**
     * Get cargo
     *
     * @return string 
     */
    public function getCargo()
    {
        return $this->cargo;
    }

    /**
     * Set idcurso
     *
     * @param \AppBundle\Entity\TblCursos $idcurso
     * @return TblCursosDocentes
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
     * Set idempleado
     *
     * @param \AppBundle\Entity\TblEmpleados $idempleado
     * @return TblCursosDocentes
     */
    public function setIdempleado(\AppBundle\Entity\TblEmpleados $idempleado = null)
    {
        $this->idempleado = $idempleado;

        return $this;
    }

    /**
     * Get idempleado
     *
     * @return \AppBundle\Entity\TblEmpleados 
     */
    public function getIdempleado()
    {
        return $this->idempleado;
    }
	
	public function __toString()
    {
        return strval($this->cargo);
    }
}
