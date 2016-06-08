<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblEstadosAulas;
use AppBundle\Form\TblEstadosAulasType;

/**
 * TblEstadosAulas controller.
 *
 * @Route("/tblestadosaulas")
 */
class TblEstadosAulasController extends Controller
{
    /**
     * Lists all TblEstadosAulas entities.
     *
     * @Route("/", name="tblestadosaulas_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tblEstadosAulas = $em->getRepository('AppBundle:TblEstadosAulas')->findAll();
    
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

                return $this->render('tblestadosaulas/index.html.twig', array(
            'tblEstadosAulas' => $tblEstadosAulas,
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
     * Creates a new TblEstadosAulas entity.
     *
     * @Route("/new", name="tblestadosaulas_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblEstadosAula = new TblEstadosAulas();
        $form = $this->createForm('AppBundle\Form\TblEstadosAulasType', $tblEstadosAula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblEstadosAula);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblestadosaulas'
              window.close()
             </script>";
        }

        return $this->render('tblestadosaulas/new.html.twig', array(
            'tblEstadosAula' => $tblEstadosAula,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TblEstadosAulas entity.
     *
     * @Route("/{id}", name="tblestadosaulas_show")
     * @Method("GET")
     */
    public function showAction(TblEstadosAulas $tblEstadosAula)
    {
        $deleteForm = $this->createDeleteForm($tblEstadosAula);

        return $this->render('tblestadosaulas/show.html.twig', array(
            'tblEstadosAula' => $tblEstadosAula,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TblEstadosAulas entity.
     *
     * @Route("/{id}/edit", name="tblestadosaulas_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblEstadosAulas $tblEstadosAula)
    {
        $deleteForm = $this->createDeleteForm($tblEstadosAula);
        $editForm = $this->createForm('AppBundle\Form\TblEstadosAulasType', $tblEstadosAula);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblEstadosAula);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../../tblestadosaulas'
              window.close()
             </script>";
        }

        return $this->render('tblestadosaulas/edit.html.twig', array(
            'tblEstadosAula' => $tblEstadosAula,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TblEstadosAulas entity.
     *
     * @Route("/{id}", name="tblestadosaulas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblEstadosAulas $tblEstadosAula)
    {
        $form = $this->createDeleteForm($tblEstadosAula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblEstadosAula);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblestadosaulas'
              window.close()
             </script>";

    }

    /**
     * Creates a form to delete a TblEstadosAulas entity.
     *
     * @param TblEstadosAulas $tblEstadosAula The TblEstadosAulas entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblEstadosAulas $tblEstadosAula)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tblestadosaulas_delete', array('id' => $tblEstadosAula->getIdestadoaula())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Finds and displays a TblEstadosAulas entity.
     *
     * @Route("/{id}/sup", name="tblestadosaulas_sup")
     * @Method("GET")
     */
    public function supAction(TblEstadosAulas $tblEstadosAula)
    {
        $deleteForm = $this->createDeleteForm($tblEstadosAula);

        return $this->render('tblestadosaulas/sup.html.twig', array(
            'tblEstadosAula' => $tblEstadosAula,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
