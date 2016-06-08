<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblMenusub;
use AppBundle\Form\TblMenusubType;

/**
 * TblMenusub controller.
 *
 * @Route("/tblmenusub")
 */
class TblMenusubController extends Controller
{
    /**
     * Lists all TblMenusub entities.
     *
     * @Route("/", name="tblmenusub_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tblMenusubs = $em->getRepository('AppBundle:TblMenusub')->findAll();

        return $this->render('tblmenusub/index.html.twig', array(
            'tblMenusubs' => $tblMenusubs,
        ));
    }

    /**
     * Creates a new TblMenusub entity.
     *
     * @Route("/new", name="tblmenusub_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblMenusub = new TblMenusub();
        $form = $this->createForm('AppBundle\Form\TblMenusubType', $tblMenusub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblMenusub);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblmenusub'
              window.close()
             </script>";
        }

        return $this->render('tblmenusub/new.html.twig', array(
            'tblMenusub' => $tblMenusub,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TblMenusub entity.
     *
     * @Route("/{id}", name="tblmenusub_show")
     * @Method("GET")
     */
    public function showAction(TblMenusub $tblMenusub)
    {
        $deleteForm = $this->createDeleteForm($tblMenusub);

        return $this->render('tblmenusub/show.html.twig', array(
            'tblMenusub' => $tblMenusub,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TblMenusub entity.
     *
     * @Route("/{id}/edit", name="tblmenusub_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblMenusub $tblMenusub)
    {
        $deleteForm = $this->createDeleteForm($tblMenusub);
        $editForm = $this->createForm('AppBundle\Form\TblMenusubType', $tblMenusub);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblMenusub);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../../tblmenusub'
              window.close()
             </script>";
        }

        return $this->render('tblmenusub/edit.html.twig', array(
            'tblMenusub' => $tblMenusub,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TblMenusub entity.
     *
     * @Route("/{id}", name="tblmenusub_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblMenusub $tblMenusub)
    {
        $form = $this->createDeleteForm($tblMenusub);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblMenusub);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblmenusub'
              window.close()
             </script>";
    }

    /**
     * Creates a form to delete a TblMenusub entity.
     *
     * @param TblMenusub $tblMenusub The TblMenusub entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblMenusub $tblMenusub)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tblmenusub_delete', array('id' => $tblMenusub->getIdsubmenu())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Finds and displays a TblMenusub entity.
     *
     * @Route("/{id}/sup", name="tblmenusub_sup")
     * @Method("GET")
     */
    public function supAction(TblMenusub $tblMenusub)
    {
        $deleteForm = $this->createDeleteForm($tblMenusub);

        return $this->render('tblmenusub/sup.html.twig', array(
            'tblMenusub' => $tblMenusub,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
