<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * TblUsuarios
 */
class TblUsuarios  implements UserInterface
{
    /**
     * @var integer
     */
    private $idusuario;

    /**
     * @var string
     */
    private $usuario;

    /**
     * @var string
     */
    private $nombreusuario;

    /**
     * @var string
     */
    private $password;

    /**
     * @var integer
     */
    private $vigencia;

    /**
     * @var integer
     */
    private $estatus;

    /**
     * @var \DateTime
     */
    private $fechaalta;

    /**
     * @var \DateTime
     */
    private $fechaestatus;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $idperfil;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idperfil = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get idusuario
     *
     * @return integer 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * Set usuario
     *
     * @param string $usuario
     * @return TblUsuarios
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set nombreusuario
     *
     * @param string $nombreusuario
     * @return TblUsuarios
     */
    public function setNombreusuario($nombreusuario)
    {
        $this->nombreusuario = $nombreusuario;

        return $this;
    }

    /**
     * Get nombreusuario
     *
     * @return string 
     */
    public function getNombreusuario()
    {
        return $this->nombreusuario;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return TblUsuarios
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set vigencia
     *
     * @param integer $vigencia
     * @return TblUsuarios
     */
    public function setVigencia($vigencia)
    {
        $this->vigencia = $vigencia;

        return $this;
    }

    /**
     * Get vigencia
     *
     * @return integer 
     */
    public function getVigencia()
    {
        return $this->vigencia;
    }

    /**
     * Set estatus
     *
     * @param integer $estatus
     * @return TblUsuarios
     */
    public function setEstatus($estatus)
    {
        $this->estatus = $estatus;

        return $this;
    }

    /**
     * Get estatus
     *
     * @return integer 
     */
    public function getEstatus()
    {
        return $this->estatus;
    }

    /**
     * Set fechaalta
     *
     * @param \DateTime $fechaalta
     * @return TblUsuarios
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
     * Set fechaestatus
     *
     * @param \DateTime $fechaestatus
     * @return TblUsuarios
     */
    public function setFechaestatus($fechaestatus)
    {
        $this->fechaestatus = $fechaestatus;

        return $this;
    }

    /**
     * Get fechaestatus
     *
     * @return \DateTime 
     */
    public function getFechaestatus()
    {
        return $this->fechaestatus;
    }

    /**
     * Add idperfil
     *
     * @param \AppBundle\Entity\TblPerfil $idperfil
     * @return TblUsuarios
     */
    public function addIdperfil(\AppBundle\Entity\TblPerfil $idperfil)
    {
      $idperfil->addIdusuario($this);
      $this->idperfil[] = $idperfil;

      return $this;
  }

    /**
     * Remove idperfil
     *
     * @param \AppBundle\Entity\TblPerfil $idperfil
     */
    public function removeIdperfil(\AppBundle\Entity\TblPerfil $idperfil)
    {
        $this->idperfil->removeElement($idperfil);
    }

    /**
     * Get idperfil
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIdperfil()
    {
        return $this->idperfil;
    }

    public function __toString()
    {
        return strval($this->nombreusuario);
    }

    public function  getRoles(){}

    public function getSalt() {}

    public function getUsername() {}

    public function eraseCredentials() {}
}
