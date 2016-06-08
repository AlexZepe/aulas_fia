<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblMateriasCarreras
 */
class TblMateriasCarreras
{
    /**
     * @var integer
     */
    private $idmateriacarrera;

    /**
     * @var string
     */
    private $codigocarrera;

    /**
     * @var \AppBundle\Entity\TblMaterias
     */
    private $idmateria;

    /**
     * @var \AppBundle\Entity\TblCarreras
     */
    private $idcarrera;


    /**
     * Set idmateriacarrera
     *
     * @param integer $idmateriacarrera
     * @return TblMateriasCarreras
     */
    public function setIdmateriacarrera($idmateriacarrera)
    {
        $this->idmateriacarrera = $idmateriacarrera;

        return $this;
    }

    /**
     * Get idmateriacarrera
     *
     * @return integer 
     */
    public function getIdmateriacarrera()
    {
        return $this->idmateriacarrera;
    }

    /**
     * Set codigocarrera
     *
     * @param string $codigocarrera
     * @return TblMateriasCarreras
     */
    public function setCodigocarrera($codigocarrera)
    {
        $this->codigocarrera = $codigocarrera;

        return $this;
    }

    /**
     * Get codigocarrera
     *
     * @return string 
     */
    public function getCodigocarrera()
    {
        return $this->codigocarrera;
    }

    /**
     * Set idmateria
     *
     * @param \AppBundle\Entity\TblMaterias $idmateria
     * @return TblMateriasCarreras
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

    /**
     * Set idcarrera
     *
     * @param \AppBundle\Entity\TblCarreras $idcarrera
     * @return TblMateriasCarreras
     */
    public function setIdcarrera(\AppBundle\Entity\TblCarreras $idcarrera = null)
    {
        $this->idcarrera = $idcarrera;

        return $this;
    }

    /**
     * Get idcarrera
     *
     * @return \AppBundle\Entity\TblCarreras 
     */
    public function getIdcarrera()
    {
        return $this->idcarrera;
    }
	
	public function __toString()
    {
        return strval($this->codigocarrera);
    }
}
