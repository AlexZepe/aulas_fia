<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblPerfil;
use AppBundle\Form\TblPerfilType;

/**
 * TblPerfil controller.
 *
 * @Route("/tblperfil")
 */
class TblPerfilController extends Controller
{
    /**
     * Lists all TblPerfil entities.
     *
     * @Route("/", name="tblperfil_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tblPerfils = $em->getRepository('AppBundle:TblPerfil')->findAll();

        return $this->render('tblperfil/index.html.twig', array(
            'tblPerfils' => $tblPerfils,
        ));
    }

    /**
     * Creates a new TblPerfil entity.
     *
     * @Route("/new", name="tblperfil_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblPerfil = new TblPerfil();
        $form = $this->createForm('AppBundle\Form\TblPerfilType', $tblPerfil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblPerfil);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblperfil'
              window.close()
             </script>";
        }

        return $this->render('tblperfil/new.html.twig', array(
            'tblPerfil' => $tblPerfil,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TblPerfil entity.
     *
     * @Route("/{id}", name="tblperfil_show")
     * @Method("GET")
     */
    public function showAction(TblPerfil $tblPerfil)
    {
        $deleteForm = $this->createDeleteForm($tblPerfil);

        return $this->render('tblperfil/show.html.twig', array(
            'tblPerfil' => $tblPerfil,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TblPerfil entity.
     *
     * @Route("/{id}/edit", name="tblperfil_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblPerfil $tblPerfil)
    {
        $deleteForm = $this->createDeleteForm($tblPerfil);
        $editForm = $this->createForm('AppBundle\Form\TblPerfilType', $tblPerfil);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblPerfil);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../../tblperfil'
              window.close()
             </script>";
        }

        return $this->render('tblperfil/edit.html.twig', array(
            'tblPerfil' => $tblPerfil,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TblPerfil entity.
     *
     * @Route("/{id}", name="tblperfil_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblPerfil $tblPerfil)
    {
        $form = $this->createDeleteForm($tblPerfil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblPerfil);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblperfil'
              window.close()
             </script>";
    }

    /**
     * Creates a form to delete a TblPerfil entity.
     *
     * @param TblPerfil $tblPerfil The TblPerfil entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblPerfil $tblPerfil)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tblperfil_delete', array('id' => $tblPerfil->getIdperfil())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Finds and displays a TblPerfil entity.
     *
     * @Route("/{id}/sup", name="tblperfil_sup")
     * @Method("GET")
     */
    public function supAction(TblPerfil $tblPerfil)
    {
        $deleteForm = $this->createDeleteForm($tblPerfil);

        return $this->render('tblperfil/sup.html.twig', array(
            'tblPerfil' => $tblPerfil,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
