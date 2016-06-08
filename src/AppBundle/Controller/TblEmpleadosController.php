<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblEmpleados;
use AppBundle\Form\TblEmpleadosType;

/**
 * TblEmpleados controller.
 *
 * @Route("/tblempleados")
 */
class TblEmpleadosController extends Controller
{
    /**
     * Lists all TblEmpleados entities.
     *
     * @Route("/", name="tblempleados_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tblEmpleados = $em->getRepository('AppBundle:TblEmpleados')->findAll();

        return $this->render('tblempleados/index.html.twig', array(
            'tblEmpleados' => $tblEmpleados,
        ));
    }

    /**
     * Creates a new TblEmpleados entity.
     *
     * @Route("/new", name="tblempleados_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblEmpleado = new TblEmpleados();
        $form = $this->createForm('AppBundle\Form\TblEmpleadosType', $tblEmpleado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblEmpleado);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblempleados'
              window.close()
             </script>";
        }

        return $this->render('tblempleados/new.html.twig', array(
            'tblEmpleado' => $tblEmpleado,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TblEmpleados entity.
     *
     * @Route("/{id}", name="tblempleados_show")
     * @Method("GET")
     */
    public function showAction(TblEmpleados $tblEmpleado)
    {
        $deleteForm = $this->createDeleteForm($tblEmpleado);

        return $this->render('tblempleados/show.html.twig', array(
            'tblEmpleado' => $tblEmpleado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TblEmpleados entity.
     *
     * @Route("/{id}/edit", name="tblempleados_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblEmpleados $tblEmpleado)
    {
        $deleteForm = $this->createDeleteForm($tblEmpleado);
        $editForm = $this->createForm('AppBundle\Form\TblEmpleadosType', $tblEmpleado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblEmpleado);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../../tblempleados'
              window.close()
             </script>";
        }

        return $this->render('tblempleados/edit.html.twig', array(
            'tblEmpleado' => $tblEmpleado,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TblEmpleados entity.
     *
     * @Route("/{id}", name="tblempleados_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblEmpleados $tblEmpleado)
    {
        $form = $this->createDeleteForm($tblEmpleado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblEmpleado);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblempleados'
              window.close()
             </script>";
    }

    /**
     * Creates a form to delete a TblEmpleados entity.
     *
     * @param TblEmpleados $tblEmpleado The TblEmpleados entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblEmpleados $tblEmpleado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tblempleados_delete', array('id' => $tblEmpleado->getIdempleado())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Finds and displays a TblEmpleados entity.
     *
     * @Route("/{id}/sup", name="tblempleados_sup")
     * @Method("GET")
     */
    public function supAction(TblEmpleados $tblEmpleado)
    {
        $deleteForm = $this->createDeleteForm($tblEmpleado);

        return $this->render('tblempleados/sup.html.twig', array(
            'tblEmpleado' => $tblEmpleado,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
