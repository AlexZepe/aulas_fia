<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblCursosDocentes;
use AppBundle\Form\TblCursosDocentesType;

/**
 * TblCursosDocentes controller.
 *
 * @Route("/tblcursosdocentes")
 */
class TblCursosDocentesController extends Controller
{
    /**
     * Lists all TblCursosDocentes entities.
     *
     * @Route("/", name="tblcursosdocentes_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tblCursosDocentes = $em->getRepository('AppBundle:TblCursosDocentes')->findAll();

        return $this->render('tblcursosdocentes/index.html.twig', array(
            'tblCursosDocentes' => $tblCursosDocentes,
        ));
    }

    /**
     * Creates a new TblCursosDocentes entity.
     *
     * @Route("/new", name="tblcursosdocentes_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblCursosDocente = new TblCursosDocentes();
        $form = $this->createForm('AppBundle\Form\TblCursosDocentesType', $tblCursosDocente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblCursosDocente);
            $em->flush();

            return $this->redirectToRoute('tblcursosdocentes_show', array('id' => $tblCursosDocente->getId()));
        }

        return $this->render('tblcursosdocentes/new.html.twig', array(
            'tblCursosDocente' => $tblCursosDocente,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TblCursosDocentes entity.
     *
     * @Route("/{id}", name="tblcursosdocentes_show")
     * @Method("GET")
     */
    public function showAction(TblCursosDocentes $tblCursosDocente)
    {
        $deleteForm = $this->createDeleteForm($tblCursosDocente);

        return $this->render('tblcursosdocentes/show.html.twig', array(
            'tblCursosDocente' => $tblCursosDocente,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TblCursosDocentes entity.
     *
     * @Route("/{id}/edit", name="tblcursosdocentes_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblCursosDocentes $tblCursosDocente)
    {
        $deleteForm = $this->createDeleteForm($tblCursosDocente);
        $editForm = $this->createForm('AppBundle\Form\TblCursosDocentesType', $tblCursosDocente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblCursosDocente);
            $em->flush();

            return $this->redirectToRoute('tblcursosdocentes_edit', array('id' => $tblCursosDocente->getId()));
        }

        return $this->render('tblcursosdocentes/edit.html.twig', array(
            'tblCursosDocente' => $tblCursosDocente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TblCursosDocentes entity.
     *
     * @Route("/{id}", name="tblcursosdocentes_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblCursosDocentes $tblCursosDocente)
    {
        $form = $this->createDeleteForm($tblCursosDocente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblCursosDocente);
            $em->flush();
        }

        return $this->redirectToRoute('tblcursosdocentes_index');
    }

    /**
     * Creates a form to delete a TblCursosDocentes entity.
     *
     * @param TblCursosDocentes $tblCursosDocente The TblCursosDocentes entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblCursosDocentes $tblCursosDocente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tblcursosdocentes_delete', array('id' => $tblCursosDocente->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
