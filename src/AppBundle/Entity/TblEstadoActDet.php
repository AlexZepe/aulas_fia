<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TblEstadoActDet
 * @UniqueEntity("nombreestadoactdet")
 */
class TblEstadoActDet
{
    /**
     * @var integer
     */
    private $idestadoactdet;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $nombreestadoactdet;

    /**
     * @var string
     */
    private $descripcionestadoactdet;


    /**
     * Get idestadoactdet
     *
     * @return integer 
     */
    public function getIdestadoactdet()
    {
        return $this->idestadoactdet;
    }

    /**
     * Set nombreestadoactdet
     *
     * @param string $nombreestadoactdet
     * @return TblEstadoActDet
     */
    public function setNombreestadoactdet($nombreestadoactdet)
    {
        $this->nombreestadoactdet = $nombreestadoactdet;

        return $this;
    }

    /**
     * Get nombreestadoactdet
     *
     * @return string 
     */
    public function getNombreestadoactdet()
    {
        return $this->nombreestadoactdet;
    }

    /**
     * Set descripcionestadoactdet
     *
     * @param string $descripcionestadoactdet
     * @return TblEstadoActDet
     */
    public function setDescripcionestadoactdet($descripcionestadoactdet)
    {
        $this->descripcionestadoactdet = $descripcionestadoactdet;

        return $this;
    }

    /**
     * Get descripcionestadoactdet
     *
     * @return string 
     */
    public function getDescripcionestadoactdet()
    {
        return $this->descripcionestadoactdet;
    }
	
	public function __toString()
    {
        return strval($this->nombreestadoactdet);
    }
}
