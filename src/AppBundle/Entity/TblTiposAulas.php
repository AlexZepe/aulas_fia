<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TblTiposAulas
 * @UniqueEntity("nombretipoaula")
 */
class TblTiposAulas
{
    /**
     * @var integer
     */
    private $idtipoaula;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $nombretipoaula;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $descripciontipoaula;


    /**
     * Get idtipoaula
     *
     * @return integer 
     */
    public function getIdtipoaula()
    {
        return $this->idtipoaula;
    }

    /**
     * Set nombretipoaula
     *
     * @param string $nombretipoaula
     * @return TblTiposAulas
     */
    public function setNombretipoaula($nombretipoaula)
    {
        $this->nombretipoaula = $nombretipoaula;

        return $this;
    }

    /**
     * Get nombretipoaula
     *
     * @return string 
     */
    public function getNombretipoaula()
    {
        return $this->nombretipoaula;
    }

    /**
     * Set descripciontipoaula
     *
     * @param string $descripciontipoaula
     * @return TblTiposAulas
     */
    public function setDescripciontipoaula($descripciontipoaula)
    {
        $this->descripciontipoaula = $descripciontipoaula;

        return $this;
    }

    /**
     * Get descripciontipoaula
     *
     * @return string 
     */
    public function getDescripciontipoaula()
    {
        return $this->descripciontipoaula;
    }
    
    public function __toString()
    {
        return strval($this->nombretipoaula);
    }
}
