<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblPuestos;
use AppBundle\Form\TblPuestosType;

/**
 * TblPuestos controller.
 *
 * @Route("/tblpuestos")
 */
class TblPuestosController extends Controller
{
    /**
     * Lists all TblPuestos entities.
     *
     * @Route("/", name="tblpuestos_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tblPuestos = $em->getRepository('AppBundle:TblPuestos')->findAll();


        $session = $request->getSession();
        if($session->has("id")){
            $menuList = array();
            $subMenuList = array();
            $menusList = $this->getDoctrine()->getEntityManager()->createQuery("SELECT m  
                FROM AppBundle:TblMenus m 
                ,AppBundle:TblPerfildetalle pd 
                ,AppBundle:TblPerfil p  
                ,AppBundle:TblUsuariosperfiles up  
                WHERE up.idusuario = :pIdUsuario
                AND pd.idmenu IS NOT NULL
                and pd.idmenu = m.idmenu
                and p.idperfil = pd.idperfil
                and up.idperfil = p.idperfil
                ORDER BY m.nombremenu ASC")->setParameters(array('pIdUsuario'=>$session->get('id')))->getResult();
            if($menusList){
                foreach ($menusList as $menuIter) {
                    $subMenu = $this->getDoctrine()->getEntityManager()->createQuery("SELECT sm
                        FROM AppBundle:TblMenus m 
                        ,AppBundle:TblMenusub sm
                        ,AppBundle:TblPerfildetalle pd
                        ,AppBundle:TblPerfil p
                        ,AppBundle:TblUsuariosperfiles up 
                        WHERE up.idusuario = :pIdUsuario
                        AND m.idmenu = :pIdMenu
                        AND pd.idsubmenu IS NOT NULL
                        and sm.idmenu = m.idmenu
                        and pd.idsubmenu = sm.idsubmenu
                        and p.idperfil = pd.idperfil
                        and up.idperfil = p.idperfil
                        ORDER BY sm.nombresubmenu ASC")->setParameters(array('pIdUsuario'=>$session->get('id'),'pIdMenu'=>$menuIter->getIdmenu()))->getResult();
                    if($subMenu){
                        foreach ($subMenu as $sm) {
                            array_push($subMenuList,$sm);
                        }
                    }
                    array_push($menuList,$menuIter);
                }

                return $this->render('tblpuestos/index.html.twig',array(
                    'tblPuestos' => $tblPuestos,
                    'menuList'=>$menuList,
                    'subMenuList'=>$subMenuList,
                    ));
            }
        }else{
            $this->get("session")->getFlashBag()->add("mensaje","Debe estar logueado para ver este contenido."); 
               return $this->redirect($this->generateUrl("login"));
        }
    }

    /**
     * Creates a new TblPuestos entity.
     *
     * @Route("/new", name="tblpuestos_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblPuesto = new TblPuestos();
        $form = $this->createForm('AppBundle\Form\TblPuestosType', $tblPuesto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblPuesto);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblpuestos'
              window.close()
             </script>";
        }

        return $this->render('tblpuestos/new.html.twig', array(
            'tblPuesto' => $tblPuesto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TblPuestos entity.
     *
     * @Route("/{id}", name="tblpuestos_show")
     * @Method("GET")
     */
    public function showAction(TblPuestos $tblPuesto)
    {
        $deleteForm = $this->createDeleteForm($tblPuesto);

        return $this->render('tblpuestos/show.html.twig', array(
            'tblPuesto' => $tblPuesto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TblPuestos entity.
     *
     * @Route("/{id}/edit", name="tblpuestos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblPuestos $tblPuesto)
    {
        $deleteForm = $this->createDeleteForm($tblPuesto);
        $editForm = $this->createForm('AppBundle\Form\TblPuestosType', $tblPuesto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblPuesto);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../../tblpuestos'
              window.close()
             </script>";
        }

        return $this->render('tblpuestos/edit.html.twig', array(
            'tblPuesto' => $tblPuesto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TblPuestos entity.
     *
     * @Route("/{id}", name="tblpuestos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblPuestos $tblPuesto)
    {
        $form = $this->createDeleteForm($tblPuesto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblPuesto);
            $em->flush();
        }

         echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblpuestos'
              window.close()
             </script>";
    }

    /**
     * Creates a form to delete a TblPuestos entity.
     *
     * @param TblPuestos $tblPuesto The TblPuestos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblPuestos $tblPuesto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tblpuestos_delete', array('id' => $tblPuesto->getIdpuesto())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Finds and displays a TblPuestos entity.
     *
     * @Route("/{id}/sup", name="tblpuestos_sup")
     * @Method("GET")
     */
    public function supAction(TblPuestos $tblPuesto)
    {
        $deleteForm = $this->createDeleteForm($tblPuesto);

        return $this->render('tblpuestos/sup.html.twig', array(
            'tblPuesto' => $tblPuesto,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
