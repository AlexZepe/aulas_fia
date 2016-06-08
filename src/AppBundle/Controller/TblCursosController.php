<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblCursos;
use AppBundle\Form\TblCursosType;

/**
 * TblCursos controller.
 *
 * @Route("/tblcursos")
 */
class TblCursosController extends Controller
{
    /**
     * Lists all TblCursos entities.
     *
     * @Route("/", name="tblcursos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tblCursos = $em->getRepository('AppBundle:TblCursos')->findAll();

        return $this->render('tblcursos/index.html.twig', array(
            'tblCursos' => $tblCursos,
        ));
    }

    /**
     * Creates a new TblCursos entity.
     *
     * @Route("/new", name="tblcursos_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblCurso = new TblCursos();
        $form = $this->createForm('AppBundle\Form\TblCursosType', $tblCurso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblCurso);
            $em->flush();

            return $this->redirectToRoute('tblcursos_show', array('id' => $tblCurso->getId()));
        }

        return $this->render('tblcursos/new.html.twig', array(
            'tblCurso' => $tblCurso,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TblCursos entity.
     *
     * @Route("/{id}", name="tblcursos_show")
     * @Method("GET")
     */
    public function showAction(TblCursos $tblCurso)
    {
        $deleteForm = $this->createDeleteForm($tblCurso);

        return $this->render('tblcursos/show.html.twig', array(
            'tblCurso' => $tblCurso,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TblCursos entity.
     *
     * @Route("/{id}/edit", name="tblcursos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblCursos $tblCurso)
    {
        $deleteForm = $this->createDeleteForm($tblCurso);
        $editForm = $this->createForm('AppBundle\Form\TblCursosType', $tblCurso);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblCurso);
            $em->flush();

            return $this->redirectToRoute('tblcursos_edit', array('id' => $tblCurso->getId()));
        }

        return $this->render('tblcursos/edit.html.twig', array(
            'tblCurso' => $tblCurso,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TblCursos entity.
     *
     * @Route("/{id}", name="tblcursos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblCursos $tblCurso)
    {
        $form = $this->createDeleteForm($tblCurso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblCurso);
            $em->flush();
        }

        return $this->redirectToRoute('tblcursos_index');
    }

    /**
     * Creates a form to delete a TblCursos entity.
     *
     * @param TblCursos $tblCurso The TblCursos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblCursos $tblCurso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tblcursos_delete', array('id' => $tblCurso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
