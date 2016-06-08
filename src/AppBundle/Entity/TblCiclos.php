<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblCiclos
 */
class TblCiclos
{
    /**
     * @var integer
     */
    private $idciclo;

    /**
     * @var integer
     */
    private $aniociclo;

    /**
     * @var integer
     */
    private $numerociclo;

    /**
     * @var \DateTime
     */
    private $fechainicio;

    /**
     * @var \DateTime
     */
    private $fechafin;


    /**
     * Get idciclo
     *
     * @return integer 
     */
    public function getIdciclo()
    {
        return $this->idciclo;
    }

    /**
     * Set aniociclo
     *
     * @param integer $aniociclo
     * @return TblCiclos
     */
    public function setAniociclo($aniociclo)
    {
        $this->aniociclo = $aniociclo;

        return $this;
    }

    /**
     * Get aniociclo
     *
     * @return integer 
     */
    public function getAniociclo()
    {
        return $this->aniociclo;
    }

    /**
     * Set numerociclo
     *
     * @param integer $numerociclo
     * @return TblCiclos
     */
    public function setNumerociclo($numerociclo)
    {
        $this->numerociclo = $numerociclo;

        return $this;
    }

    /**
     * Get numerociclo
     *
     * @return integer 
     */
    public function getNumerociclo()
    {
        return $this->numerociclo;
    }

    /**
     * Set fechainicio
     *
     * @param \DateTime $fechainicio
     * @return TblCiclos
     */
    public function setFechainicio($fechainicio)
    {
        $this->fechainicio = $fechainicio;

        return $this;
    }

    /**
     * Get fechainicio
     *
     * @return \DateTime 
     */
    public function getFechainicio()
    {
        return $this->fechainicio;
    }

    /**
     * Set fechafin
     *
     * @param \DateTime $fechafin
     * @return TblCiclos
     */
    public function setFechafin($fechafin)
    {
        $this->fechafin = $fechafin;

        return $this;
    }

    /**
     * Get fechafin
     *
     * @return \DateTime 
     */
    public function getFechafin()
    {
        return $this->fechafin;
    }
	
	public function __toString()
    {
        return strval($this->numerociclo);
    }
}
