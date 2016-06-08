<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblActividadesDetalle
 */
class TblActividadesDetalle
{
    /**
     * @var integer
     */
    private $idactividadesdetalle;

    /**
     * @var \DateTime
     */
    private $dia;

    /**
     * @var string
     */
    private $horainicio;

    /**
     * @var string
     */
    private $horafin;

    /**
     * @var integer
     */
    private $estado;

    /**
     * @var integer
     */
    private $correlativo;

    /**
     * @var \AppBundle\Entity\TblEstadoActDet
     */
    private $idestadoactdet;

    /**
     * @var \AppBundle\Entity\TblActividades
     */
    private $idactividad;

    /**
     * @var \AppBundle\Entity\TblAulas
     */
    private $idaula;


    /**
     * Set idactividadesdetalle
     *
     * @param integer $idactividadesdetalle
     * @return TblActividadesDetalle
     */
    public function setIdactividadesdetalle($idactividadesdetalle)
    {
        $this->idactividadesdetalle = $idactividadesdetalle;

        return $this;
    }

    /**
     * Get idactividadesdetalle
     *
     * @return integer 
     */
    public function getIdactividadesdetalle()
    {
        return $this->idactividadesdetalle;
    }

    /**
     * Set dia
     *
     * @param \DateTime $dia
     * @return TblActividadesDetalle
     */
    public function setDia($dia)
    {
        $this->dia = $dia;

        return $this;
    }

    /**
     * Get dia
     *
     * @return \DateTime 
     */
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * Set horainicio
     *
     * @param string $horainicio
     * @return TblActividadesDetalle
     */
    public function setHorainicio($horainicio)
    {
        $this->horainicio = $horainicio;

        return $this;
    }

    /**
     * Get horainicio
     *
     * @return string 
     */
    public function getHorainicio()
    {
        return $this->horainicio;
    }

    /**
     * Set horafin
     *
     * @param string $horafin
     * @return TblActividadesDetalle
     */
    public function setHorafin($horafin)
    {
        $this->horafin = $horafin;

        return $this;
    }

    /**
     * Get horafin
     *
     * @return string 
     */
    public function getHorafin()
    {
        return $this->horafin;
    }

    /**
     * Set estado
     *
     * @param integer $estado
     * @return TblActividadesDetalle
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return integer 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set correlativo
     *
     * @param integer $correlativo
     * @return TblActividadesDetalle
     */
    public function setCorrelativo($correlativo)
    {
        $this->correlativo = $correlativo;

        return $this;
    }

    /**
     * Get correlativo
     *
     * @return integer 
     */
    public function getCorrelativo()
    {
        return $this->correlativo;
    }

    /**
     * Set idestadoactdet
     *
     * @param \AppBundle\Entity\TblEstadoActDet $idestadoactdet
     * @return TblActividadesDetalle
     */
    public function setIdestadoactdet(\AppBundle\Entity\TblEstadoActDet $idestadoactdet = null)
    {
        $this->idestadoactdet = $idestadoactdet;

        return $this;
    }

    /**
     * Get idestadoactdet
     *
     * @return \AppBundle\Entity\TblEstadoActDet 
     */
    public function getIdestadoactdet()
    {
        return $this->idestadoactdet;
    }

    /**
     * Set idactividad
     *
     * @param \AppBundle\Entity\TblActividades $idactividad
     * @return TblActividadesDetalle
     */
    public function setIdactividad(\AppBundle\Entity\TblActividades $idactividad = null)
    {
        $this->idactividad = $idactividad;

        return $this;
    }

    /**
     * Get idactividad
     *
     * @return \AppBundle\Entity\TblActividades 
     */
    public function getIdactividad()
    {
        return $this->idactividad;
    }

    /**
     * Set idaula
     *
     * @param \AppBundle\Entity\TblAulas $idaula
     * @return TblActividadesDetalle
     */
    public function setIdaula(\AppBundle\Entity\TblAulas $idaula = null)
    {
        $this->idaula = $idaula;

        return $this;
    }

    /**
     * Get idaula
     *
     * @return \AppBundle\Entity\TblAulas 
     */
    public function getIdaula()
    {
        return $this->idaula;
    }
	
	public function __toString()
    {
        return strval($this->idactividadesdetalle);
    }
}
