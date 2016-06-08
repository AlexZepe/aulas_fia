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
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tblMenusubs = $em->getRepository('AppBundle:TblMenusub')->findAll();

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

                return $this->render('tblmenusub/index.html.twig', array(
            'tblMenusubs' => $tblMenusubs,
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
