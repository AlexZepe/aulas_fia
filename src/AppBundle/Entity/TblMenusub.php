<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblMenusub
 */
class TblMenusub
{
    /**
     * @var integer
     */
    private $idmenu;

    /**
     * @var string
     */
    private $nombresubmenu;

    /**
     * @var string
     */
    private $url;

    /**
     * @var \DateTime
     */
    private $fechaalta;

    /**
     * @var integer
     */
    private $idsubmenu;

    /**
     * @var \AppBundle\Entity\TblMenus
     */
    private $tblmenu;


    /**
     * Set idmenu
     *
     * @param integer $idmenu
     * @return TblMenusub
     */
    public function setIdmenu($idmenu)
    {
        $this->idmenu = $idmenu;

        return $this;
    }

    /**
     * Get idmenu
     *
     * @return integer 
     */
    public function getIdmenu()
    {
        return $this->idmenu;
    }

    /**
     * Set nombresubmenu
     *
     * @param string $nombresubmenu
     * @return TblMenusub
     */
    public function setNombresubmenu($nombresubmenu)
    {
        $this->nombresubmenu = $nombresubmenu;

        return $this;
    }

    /**
     * Get nombresubmenu
     *
     * @return string 
     */
    public function getNombresubmenu()
    {
        return $this->nombresubmenu;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return TblMenusub
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set fechaalta
     *
     * @param \DateTime $fechaalta
     * @return TblMenusub
     */
    public function setFechaalta($fechaalta)
    {
        $this->fechaalta = $fechaalta;

        return $this;
    }

    /**
     * Get fechaalta
     *
     * @return \DateTime 
     */
    public function getFechaalta()
    {
        return $this->fechaalta;
    }

    /**
     * Get idsubmenu
     *
     * @return integer 
     */
    public function getIdsubmenu()
    {
        return $this->idsubmenu;
    }

    /**
     * Set tblmenu
     *
     * @param \AppBundle\Entity\TblMenus $tblmenu
     * @return TblMenusub
     */
    public function setTblmenu(\AppBundle\Entity\TblMenus $tblmenu = null)
    {
        $this->tblmenu = $tblmenu;

        return $this;
    }

    /**
     * Get tblmenu
     *
     * @return \AppBundle\Entity\TblMenus 
     */
    public function getTblmenu()
    {
        return $this->tblmenu;
    }

    public function __toString()
    {
        return strval($this->nombresubmenu);
    }
}
