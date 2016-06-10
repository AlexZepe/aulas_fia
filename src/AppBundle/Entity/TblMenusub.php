<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TblMenusub
 */
class TblMenusub
{
    
    /**
     * @var integer
     */
    private $idsubmenu;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $nombresubmenu;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $url;

    /**
     * @var \DateTime
     */
    private $fechaalta;

    /**
     * @var integer
     * @var \AppBundle\Entity\TblMenus
     * @Assert\NotBlank()
     */
    private $idmenu;


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
     * Set idmenu
     *
     * @param \AppBundle\Entity\TblMenus $idmenu
     * @return TblMenusub
     */
    public function setIdmenu(\AppBundle\Entity\TblMenus $idmenu = null)
    {
        $this->idmenu = $idmenu;

        return $this;
    }

    /**
     * Get idmenu
     *
     * @return \AppBundle\Entity\TblMenus 
     */
    public function getIdmenu()
    {
        return $this->idmenu;
    }

    public function __toString()
    {
        return strval($this->nombresubmenu);
    }
}
