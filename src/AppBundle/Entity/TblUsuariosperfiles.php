<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TblUsuariosperfiles
 */
class TblUsuariosperfiles
{
    /**
     * @var integer
     */
    private $idusuarioperfil;

    /**
     * @var \AppBundle\Entity\TblUsuarios
     */
    private $idusuario;

    /**
     * @var \AppBundle\Entity\TblPerfil
     */
    private $idperfil;


    /**
     * Get idusuarioperfil
     *
     * @return integer 
     */
    public function getIdusuarioperfil()
    {
        return $this->idusuarioperfil;
    }

    /**
     * Set idusuario
     *
     * @param \AppBundle\Entity\TblUsuarios $idusuario
     * @return TblUsuariosperfiles
     */
    public function setIdusuario(\AppBundle\Entity\TblUsuarios $idusuario = null)
    {
        $this->idusuario = $idusuario;

        return $this;
    }

    /**
     * Get idusuario
     *
     * @return \AppBundle\Entity\TblUsuarios 
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * Set idperfil
     *
     * @param \AppBundle\Entity\TblPerfil $idperfil
     * @return TblUsuariosperfiles
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
}
