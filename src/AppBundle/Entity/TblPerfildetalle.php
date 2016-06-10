<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TblPerfildetalle
 */
class TblPerfildetalle
{
    /**
     * @var integer
     */
    private $idperfildetalle;

    /**
     * @var string
     */
    private $comentario;

    /**
     * @var \DateTime
     */
    private $fechaalta;

    /**
     * @var \AppBundle\Entity\TblMenus
     */
    private $idmenu;

    /**
     * @var \AppBundle\Entity\TblMenusub
     */
    private $idsubmenu;

    /**
     * @var \AppBundle\Entity\TblPerfil
     */
    private $idperfil;


    /**
     * Get idperfildetalle
     *
     * @return integer 
     */
    public function getIdperfildetalle()
    {
        return $this->idperfildetalle;
    }

    /**
     * Set comentario
     *
     * @param string $comentario
     * @return TblPerfildetalle
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string 
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * Set fechaalta
     *
     * @param \DateTime $fechaalta
     * @return TblPerfildetalle
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
     * Set idmenu
     *
     * @param \AppBundle\Entity\TblMenus $idmenu
     * @return TblPerfildetalle
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

    /**
     * Set idsubmenu
     *
     * @param \AppBundle\Entity\TblMenusub $idsubmenu
     * @return TblPerfildetalle
     */
    public function setIdsubmenu(\AppBundle\Entity\TblMenusub $idsubmenu = null)
    {
        $this->idsubmenu = $idsubmenu;

        return $this;
    }

    /**
     * Get idsubmenu
     *
     * @return \AppBundle\Entity\TblMenusub 
     */
    public function getIdsubmenu()
    {
        return $this->idsubmenu;
    }

    /**
     * Set idperfil
     *
     * @param \AppBundle\Entity\TblPerfil $idperfil
     * @return TblPerfildetalle
     */
    public function setIdperfil(\AppBundle\Entity\TblPerfil $idperfil = null)
    {
        $this->idperfil = $idperfil;

        return $this;
    }

    /**
     * Get idperfil
     *
     * @return \AppBundle\Entity\TblPerfil 
     */
    public function getIdperfil()
    {
        return $this->idperfil;
    }
	
	public function __toString()
    {
        return strval($this->idperfildetalle);
    }
}
