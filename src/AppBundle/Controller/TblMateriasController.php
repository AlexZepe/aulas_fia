<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblMaterias;
use AppBundle\Form\TblMateriasType;

/**
 * TblMaterias controller.
 *
 * @Route("/tblmaterias")
 */
class TblMateriasController extends Controller
{
    /**
     * Lists all TblMaterias entities.
     *
     * @Route("/", name="tblmaterias_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tblMaterias = $em->getRepository('AppBundle:TblMaterias')->findAll();

        return $this->render('tblmaterias/index.html.twig', array(
            'tblMaterias' => $tblMaterias,
        ));
    }

    /**
     * Creates a new TblMaterias entity.
     *
     * @Route("/new", name="tblmaterias_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblMateria = new TblMaterias();
        $form = $this->createForm('AppBundle\Form\TblMateriasType', $tblMateria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblMateria);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblmaterias'
              window.close()
             </script>";
        }

        return $this->render('tblmaterias/new.html.twig', array(
            'tblMateria' => $tblMateria,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TblMaterias entity.
     *
     * @Route("/{id}", name="tblmaterias_show")
     * @Method("GET")
     */
    public function showAction(TblMaterias $tblMateria)
    {
        $deleteForm = $this->createDeleteForm($tblMateria);

        return $this->render('tblmaterias/show.html.twig', array(
            'tblMateria' => $tblMateria,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TblMaterias entity.
     *
     * @Route("/{id}/edit", name="tblmaterias_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblMaterias $tblMateria)
    {
        $deleteForm = $this->createDeleteForm($tblMateria);
        $editForm = $this->createForm('AppBundle\Form\TblMateriasType', $tblMateria);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblMateria);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../../tblmaterias'
              window.close()
             </script>";
        }

        return $this->render('tblmaterias/edit.html.twig', array(
            'tblMateria' => $tblMateria,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TblMaterias entity.
     *
     * @Route("/{id}", name="tblmaterias_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblMaterias $tblMateria)
    {
        $form = $this->createDeleteForm($tblMateria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblMateria);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblmaterias'
              window.close()
             </script>";
    }

    /**
     * Creates a form to delete a TblMaterias entity.
     *
     * @param TblMaterias $tblMateria The TblMaterias entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblMaterias $tblMateria)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tblmaterias_delete', array('id' => $tblMateria->getIdmateria())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Finds and displays a TblMaterias entity.
     *
     * @Route("/{id}/sup", name="tblmaterias_sup")
     * @Method("GET")
     */
    public function supAction(TblMaterias $tblMateria)
    {
        $deleteForm = $this->createDeleteForm($tblMateria);

        return $this->render('tblmaterias/sup.html.twig', array(
            'tblMateria' => $tblMateria,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
