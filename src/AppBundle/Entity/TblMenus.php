<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TblMenus
 */
 
class TblMenus
{
    /**
     * @var integer
     */
    private $idmenu;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private $nombremenu;

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
     * Get idmenu
     *
     * @return integer 
     */
    public function getIdmenu()
    {
        return $this->idmenu;
    }

    /**
     * Set nombremenu
     *
     * @param string $nombremenu
     * @return TblMenus
     */
    public function setNombremenu($nombremenu)
    {
        $this->nombremenu = $nombremenu;

        return $this;
    }

    /**
     * Get nombremenu
     *
     * @return string 
     */
    public function getNombremenu()
    {
        return $this->nombremenu;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return TblMenus
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
     * @return TblMenus
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
	
	public function __toString()
    {
        return strval($this->nombremenu);
    }
}
