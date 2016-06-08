<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblAulas;
use AppBundle\Form\TblAulasType;
use AppBundle\Controller\IndexController;

/**
 * TblAulas controller.
 *
 * @Route("/tblaulas")
 */
class TblAulasController extends Controller
{
    /**
     * Lists all TblAulas entities.
     *
     * @Route("/", name="tblaulas_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tblAulas = $em->getRepository('AppBundle:TblAulas')->findAll();

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

                $facultades = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblFacultades')->findAll();

                $escuelas = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblEscuelas')->findAll();

                return $this->render('tblaulas/index.html.twig', array(
                    'tblAulas' => $tblAulas,
                    'menuList'=>$menuList,
                    'subMenuList'=>$subMenuList,
                    ));
            }
        }else{
            $this->get("session")->getFlashBag()->add("mensaje","Debe estar logueado para ver este contenido."); 
               return $this->redirect($this->generateUrl("login"));
        }
        return $this->render('AppBundle:Cursos:cursos.html.twig');



        

        return $this->render('tblaulas/index.html.twig', array(
            'tblAulas' => $tblAulas,
        ));
    }

    /**
     * Creates a new TblAulas entity.
     *
     * @Route("/new", name="tblaulas_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblAula = new TblAulas();
        $form = $this->createForm('AppBundle\Form\TblAulasType', $tblAula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblAula);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblaulas'
              window.close()
             </script>";
        }

        return $this->render('tblaulas/new.html.twig', array(
            'tblAula' => $tblAula,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TblAulas entity.
     *
     * @Route("/{id}", name="tblaulas_show")
     * @Method("GET")
     */
    public function showAction(TblAulas $tblAula)
    {
        $deleteForm = $this->createDeleteForm($tblAula);

        return $this->render('tblaulas/show.html.twig', array(
            'tblAula' => $tblAula,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TblAulas entity.
     *
     * @Route("/{id}/edit", name="tblaulas_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblAulas $tblAula)
    {
        $deleteForm = $this->createDeleteForm($tblAula);
        $editForm = $this->createForm('AppBundle\Form\TblAulasType', $tblAula);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblAula);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../../tblaulas'
              window.close()
             </script>";
        }

        return $this->render('tblaulas/edit.html.twig', array(
            'tblAula' => $tblAula,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TblAulas entity.
     *
     * @Route("/{id}", name="tblaulas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblAulas $tblAula)
    {
        $form = $this->createDeleteForm($tblAula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblAula);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
              window.opener.location='../tblaulas'
              window.close()
             </script>";
    }

    /**
     * Creates a form to delete a TblAulas entity.
     *
     * @param TblAulas $tblAula The TblAulas entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblAulas $tblAula)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tblaulas_delete', array('id' => $tblAula->getIdaula())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Finds and displays a TblAulas entity.
     *
     * @Route("/{id}/sup", name="tblaulas_sup")
     * @Method("GET")
     */
    public function supAction(TblAulas $tblAula)
    {
        $deleteForm = $this->createDeleteForm($tblAula);

        return $this->render('tblaulas/sup.html.twig', array(
            'tblAula' => $tblAula,
            'delete_form' => $deleteForm->createView(),
        ));
    }
}
