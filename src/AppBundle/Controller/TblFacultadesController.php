<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblFacultades;
use AppBundle\Form\TblFacultadesType;

/**
 * TblFacultades controller.
 *
 * @Route("/tblfacultades")
 */
class TblFacultadesController extends Controller
{
    /**
     * Lists all TblFacultades entities.
     *
     * @Route("/", name="tblfacultades_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tblFacultades = $em->getRepository('AppBundle:TblFacultades')->findAll();

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

                return $this->render('tblfacultades/index.html.twig', array(
                    'tblFacultades' => $tblFacultades,
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
     * Creates a new TblFacultades entity.
     *
     * @Route("/new", name="tblfacultades_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblFacultade = new TblFacultades();
        $form = $this->createForm('AppBundle\Form\TblFacultadesType', $tblFacultade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblFacultade);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblfacultades'
              window.close()
             </script>";
        }

        return $this->render('tblfacultades/new.html.twig', array(
            'tblFacultade' => $tblFacultade,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TblFacultades entity.
     *
     * @Route("/{id}", name="tblfacultades_show")
     * @Method("GET")
     */
    public function showAction(TblFacultades $tblFacultade)
    {
        $deleteForm = $this->createDeleteForm($tblFacultade);

        return $this->render('tblfacultades/show.html.twig', array(
            'tblFacultade' => $tblFacultade,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TblFacultades entity.
     *
     * @Route("/{id}/edit", name="tblfacultades_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblFacultades $tblFacultade)
    {
        $deleteForm = $this->createDeleteForm($tblFacultade);
        $editForm = $this->createForm('AppBundle\Form\TblFacultadesType', $tblFacultade);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblFacultade);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../../tblfacultades'
              window.close()
             </script>";
        }

        return $this->render('tblfacultades/edit.html.twig', array(
            'tblFacultade' => $tblFacultade,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TblFacultades entity.
     *
     * @Route("/{id}", name="tblfacultades_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblFacultades $tblFacultade)
    {
        $form = $this->createDeleteForm($tblFacultade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblFacultade);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblfacultades'
              window.close()
             </script>";
    }

    /**
     * Creates a form to delete a TblFacultades entity.
     *
     * @param TblFacultades $tblFacultade The TblFacultades entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblFacultades $tblFacultade)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tblfacultades_delete', array('id' => $tblFacultade->getIdfacultad())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Finds and displays a TblFacultades entity.
     *
     * @Route("/{id}/sup", name="tblfacultades_sup")
     * @Method("GET")
     */
    public function supAction(TblFacultades $tblFacultade)
    {
        $deleteForm = $this->createDeleteForm($tblFacultade);

        return $this->render('tblfacultades/sup.html.twig', array(
            'tblFacultade' => $tblFacultade,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
