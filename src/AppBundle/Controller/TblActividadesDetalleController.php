<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblActividadesDetalle;

/**
 * TblActividadesDetalle controller.
 *
 * @Route("/tblactividadesdetalle")
 */
class TblActividadesDetalleController extends Controller
{
    /**
     * Lists all TblActividadesDetalle entities.
     *
     * @Route("/", name="tblactividadesdetalle_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tblActividadesDetalles = $em->getRepository('AppBundle:TblActividadesDetalle')->findAll();

        return $this->render('tblactividadesdetalle/index.html.twig', array(
            'tblActividadesDetalles' => $tblActividadesDetalles,
        ));
    }

    /**
     * Finds and displays a TblActividadesDetalle entity.
     *
     * @Route("/{id}", name="tblactividadesdetalle_show")
     * @Method("GET")
     */
    public function showAction(TblActividadesDetalle $tblActividadesDetalle)
    {

        return $this->render('tblactividadesdetalle/show.html.twig', array(
            'tblActividadesDetalle' => $tblActividadesDetalle,
        ));
    }
}
