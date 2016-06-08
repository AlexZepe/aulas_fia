<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblEscuelas;
use AppBundle\Form\TblEscuelasType;

/**
 * TblEscuelas controller.
 *
 * @Route("/tblescuelas")
 */
class TblEscuelasController extends Controller
{
    /**
     * Lists all TblEscuelas entities.
     *
     * @Route("/", name="tblescuelas_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tblEscuelas = $em->getRepository('AppBundle:TblEscuelas')->findAll();

        return $this->render('tblescuelas/index.html.twig', array(
            'tblEscuelas' => $tblEscuelas,
        ));
    }

    /**
     * Creates a new TblEscuelas entity.
     *
     * @Route("/new", name="tblescuelas_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblEscuela = new TblEscuelas();
        $form = $this->createForm('AppBundle\Form\TblEscuelasType', $tblEscuela);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblEscuela);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblescuelas'
              window.close()
             </script>";
        }

        return $this->render('tblescuelas/new.html.twig', array(
            'tblEscuela' => $tblEscuela,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TblEscuelas entity.
     *
     * @Route("/{id}", name="tblescuelas_show")
     * @Method("GET")
     */
    public function showAction(TblEscuelas $tblEscuela)
    {
        $deleteForm = $this->createDeleteForm($tblEscuela);

        return $this->render('tblescuelas/show.html.twig', array(
            'tblEscuela' => $tblEscuela,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TblEscuelas entity.
     *
     * @Route("/{id}/edit", name="tblescuelas_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblEscuelas $tblEscuela)
    {
        $deleteForm = $this->createDeleteForm($tblEscuela);
        $editForm = $this->createForm('AppBundle\Form\TblEscuelasType', $tblEscuela);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblEscuela);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../../tblescuelas'
              window.close()
             </script>";
        }

        return $this->render('tblescuelas/edit.html.twig', array(
            'tblEscuela' => $tblEscuela,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TblEscuelas entity.
     *
     * @Route("/{id}", name="tblescuelas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblEscuelas $tblEscuela)
    {
        $form = $this->createDeleteForm($tblEscuela);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblEscuela);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblescuelas'
              window.close()
             </script>";
    }

    /**
     * Creates a form to delete a TblEscuelas entity.
     *
     * @param TblEscuelas $tblEscuela The TblEscuelas entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblEscuelas $tblEscuela)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tblescuelas_delete', array('id' => $tblEscuela->getIdescuela())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Finds and displays a TblEscuelas entity.
     *
     * @Route("/{id}/sup", name="tblescuelas_sup")
     * @Method("GET")
     */
    public function supAction(TblEscuelas $tblEscuela)
    {
        $deleteForm = $this->createDeleteForm($tblEscuela);

        return $this->render('tblescuelas/sup.html.twig', array(
            'tblEscuela' => $tblEscuela,
            'delete_form' => $deleteForm->createView(),
        ));
    }

}
