<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TblFacultades
 * @UniqueEntity("nombrefacultad")
 */
class TblFacultades
{
    /**
     * @var integer
     */
    private $idfacultad;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $nombrefacultad;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $siglasfacultad;

    /**
     * @var string
     */
    private $descripcionfacultad;


    /**
     * Get idfacultad
     *
     * @return integer 
     */
    public function getIdfacultad()
    {
        return $this->idfacultad;
    }

    /**
     * Set nombrefacultad
     *
     * @param string $nombrefacultad
     * @return TblFacultades
     */
    public function setNombrefacultad($nombrefacultad)
    {
        $this->nombrefacultad = $nombrefacultad;

        return $this;
    }

    /**
     * Get nombrefacultad
     *
     * @return string 
     */
    public function getNombrefacultad()
    {
        return $this->nombrefacultad;
    }

    /**
     * Set siglasfacultad
     *
     * @param string $siglasfacultad
     * @return TblFacultades
     */
    public function setSiglasfacultad($siglasfacultad)
    {
        $this->siglasfacultad = $siglasfacultad;

        return $this;
    }

    /**
     * Get siglasfacultad
     *
     * @return string 
     */
    public function getSiglasfacultad()
    {
        return $this->siglasfacultad;
    }

    /**
     * Set descripcionfacultad
     *
     * @param string $descripcionfacultad
     * @return TblFacultades
     */
    public function setDescripcionfacultad($descripcionfacultad)
    {
        $this->descripcionfacultad = $descripcionfacultad;

        return $this;
    }

    /**
     * Get descripcionfacultad
     *
     * @return string 
     */
    public function getDescripcionfacultad()
    {
        return $this->descripcionfacultad;
    }
	
	public function __toString()
    {
        return strval($this->nombrefacultad);
    }
}
