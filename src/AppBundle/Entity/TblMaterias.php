<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblMaterias
 */
class TblMaterias
{
    /**
     * @var integer
     */
    private $idmateria;

    /**
     * @var string
     */
    private $codigomateria;

    /**
     * @var string
     */
    private $nombremateria;

    /**
     * @var string
     */
    private $descripcionmateria;

    /**
     * @var \AppBundle\Entity\TblEscuelas
     */
    private $idescuela;


    /**
     * Get idmateria
     *
     * @return integer 
     */
    public function getIdmateria()
    {
        return $this->idmateria;
    }

    /**
     * Set codigomateria
     *
     * @param string $codigomateria
     * @return TblMaterias
     */
    public function setCodigomateria($codigomateria)
    {
        $this->codigomateria = $codigomateria;

        return $this;
    }

    /**
     * Get codigomateria
     *
     * @return string 
     */
    public function getCodigomateria()
    {
        return $this->codigomateria;
    }

    /**
     * Set nombremateria
     *
     * @param string $nombremateria
     * @return TblMaterias
     */
    public function setNombremateria($nombremateria)
    {
        $this->nombremateria = $nombremateria;

        return $this;
    }

    /**
     * Get nombremateria
     *
     * @return string 
     */
    public function getNombremateria()
    {
        return $this->nombremateria;
    }

    /**
     * Set descripcionmateria
     *
     * @param string $descripcionmateria
     * @return TblMaterias
     */
    public function setDescripcionmateria($descripcionmateria)
    {
        $this->descripcionmateria = $descripcionmateria;

        return $this;
    }

    /**
     * Get descripcionmateria
     *
     * @return string 
     */
    public function getDescripcionmateria()
    {
        return $this->descripcionmateria;
    }

    /**
     * Set idescuela
     *
     * @param \AppBundle\Entity\TblEscuelas $idescuela
     * @return TblMaterias
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
        return strval($this->nombremateria);
    }
}
