<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TblEscuelas
 * @UniqueEntity("nombreescuela")
 */
class TblEscuelas
{
    /**
     * @var integer
     */
    private $idescuela;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $nombreescuela;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $siglasescuela;

    /**
     * @var string
     */
    private $descripcionescuela;

    /**
     * @var \AppBundle\Entity\TblFacultades
     * @Assert\NotBlank()
     */
    private $idfacultad;


    /**
     * Get idescuela
     *
     * @return integer 
     */
    public function getIdescuela()
    {
        return $this->idescuela;
    }

    /**
     * Set nombreescuela
     *
     * @param string $nombreescuela
     * @return TblEscuelas
     */
    public function setNombreescuela($nombreescuela)
    {
        $this->nombreescuela = $nombreescuela;

        return $this;
    }

    /**
     * Get nombreescuela
     *
     * @return string 
     */
    public function getNombreescuela()
    {
        return $this->nombreescuela;
    }

    /**
     * Set siglasescuela
     *
     * @param string $siglasescuela
     * @return TblEscuelas
     */
    public function setSiglasescuela($siglasescuela)
    {
        $this->siglasescuela = $siglasescuela;

        return $this;
    }

    /**
     * Get siglasescuela
     *
     * @return string 
     */
    public function getSiglasescuela()
    {
        return $this->siglasescuela;
    }

    /**
     * Set descripcionescuela
     *
     * @param string $descripcionescuela
     * @return TblEscuelas
     */
    public function setDescripcionescuela($descripcionescuela)
    {
        $this->descripcionescuela = $descripcionescuela;

        return $this;
    }

    /**
     * Get descripcionescuela
     *
     * @return string 
     */
    public function getDescripcionescuela()
    {
        return $this->descripcionescuela;
    }

    /**
     * Set idfacultad
     *
     * @param \AppBundle\Entity\TblFacultades $idfacultad
     * @return TblEscuelas
     */
    public function setIdfacultad(\AppBundle\Entity\TblFacultades $idfacultad = null)
    {
        $this->idfacultad = $idfacultad;

        return $this;
    }

    /**
     * Get idfacultad
     *
     * @return \AppBundle\Entity\TblFacultades 
     */
    public function getIdfacultad()
    {
        return $this->idfacultad;
    }
	
	public function __toString()
    {
        return strval($this->nombreescuela);
    }
}
