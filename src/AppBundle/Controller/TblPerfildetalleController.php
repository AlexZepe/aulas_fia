<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblPerfildetalle;
use AppBundle\Form\TblPerfildetalleType;
use AppBundle\Entity\TblPerfil;

/**
 * TblPerfildetalle controller.
 *
 * @Route("/tblperfildetalle")
 */
class TblPerfildetalleController extends Controller
{
    /**
     * Lists all TblPerfildetalle entities.
     *
     * @Route("/", name="tblperfildetalle_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tblPerfildetalles = $em->getRepository('AppBundle:TblPerfildetalle')->findAll();

  
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

                return $this->render('tblperfildetalle/index.html.twig', array(
            'tblPerfildetalles' => $tblPerfildetalles,
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
     * Creates a new TblPerfildetalle entity.
     *
     * @Route("/new/{id}", name="tblperfildetalle_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $id)
    {
        $tblPerfildetalle = new TblPerfildetalle();
       

        $form = $this->createForm('AppBundle\Form\TblPerfildetalleType', $tblPerfildetalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $perfil =$em->getRepository('AppBundle:TblPerfil')->find($id); 
            $tblPerfildetalle->setIdperfil($perfil);
            $em->persist($tblPerfildetalle);
            $em->flush();

             echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../$id/pdet'
            window.close()
        </script>";

           
    }

    return $this->render('tblperfildetalle/new.html.twig', array(
        'tblPerfildetalle' => $tblPerfildetalle,
        'form' => $form->createView(),
        ));
}

    /**
     * Finds and displays a TblPerfildetalle entity.
     *
     * @Route("/{id}", name="tblperfildetalle_show")
     * @Method("GET")
     */
    public function showAction(TblPerfildetalle $tblPerfildetalle)
    {
        $deleteForm = $this->createDeleteForm($tblPerfildetalle);

        return $this->render('tblperfildetalle/show.html.twig', array(
            'tblPerfildetalle' => $tblPerfildetalle,
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * Displays a form to edit an existing TblPerfildetalle entity.
     *
     * @Route("/{id}/edit", name="tblperfildetalle_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblPerfildetalle $tblPerfildetalle)
    {
        $deleteForm = $this->createDeleteForm($tblPerfildetalle);
        $editForm = $this->createForm('AppBundle\Form\TblPerfildetalleType', $tblPerfildetalle);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblPerfildetalle);
            $em->flush();

            $id = $tblPerfildetalle->getIdperfil()->getIdperfil();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../$id/pdet'
            window.close()
        </script>";
    }

    return $this->render('tblperfildetalle/edit.html.twig', array(
        'tblPerfildetalle' => $tblPerfildetalle,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        ));
}

    /**
     * Deletes a TblPerfildetalle entity.
     *
     * @Route("/{id}", name="tblperfildetalle_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblPerfildetalle $tblPerfildetalle)
    {
        $form = $this->createDeleteForm($tblPerfildetalle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblPerfildetalle);
            $em->flush();

            $id = $tblPerfildetalle->getIdperfil()->getIdperfil();
        }

        echo "<script language='Javascript' type='text/javascript'>
        window.opener.location='../tblperfildetalle/$id/pdet'
        window.close()
    </script>";
}

    /**
     * Creates a form to delete a TblPerfildetalle entity.
     *
     * @param TblPerfildetalle $tblPerfildetalle The TblPerfildetalle entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblPerfildetalle $tblPerfildetalle)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('tblperfildetalle_delete', array('id' => $tblPerfildetalle->getIdperfildetalle())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    /**
     * Finds and displays a TblPerfildetalle entity.
     *
     * @Route("/{id}/sup", name="tblperfildetalle_sup")
     * @Method("GET")
     */
    public function supAction(TblPerfildetalle $tblPerfildetalle)
    {
        $deleteForm = $this->createDeleteForm($tblPerfildetalle);

        return $this->render('tblperfildetalle/sup.html.twig', array(
            'tblPerfildetalle' => $tblPerfildetalle,
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * Lists all TblPerfildetalle entities.
     *
     * @Route("/{id}/pdet", name="tblperfildetalle_pdet")
     * @Method("GET")
     */
    public function pdetAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery('SELECT p FROM AppBundle:TblPerfildetalle p  WHERE p.idperfil = :price' )->setParameter('price', $id);

        $products = $query->getResult();       

        return $this->render('tblperfildetalle/pdet.html.twig', array(
            'tblPerfildetalles' => $products,
            'idperfil' => $id,
            ));
    }
}
