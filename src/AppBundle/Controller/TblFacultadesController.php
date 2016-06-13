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

        $session = $request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $tblFacultades = $em->getRepository('AppBundle:TblFacultades')->findAll();            
            $db = $em->getConnection();
            $menuList = array();
            $subMenuList = array();
            
            $iduser = $session->get('id');
            $user = $em->getRepository('AppBundle:TblUsuarios')->find($iduser);

            $array = $this->obtenerMenus($iduser);
            $menuList = $array[0];
            $subMenuList = $array[1];
            
            return $this->render('tblfacultades/index.html.twig', array(
                'usuariologeado'=>$user,
                'tblFacultades' => $tblFacultades,
                'menuList'=>$menuList,
                'subMenuList'=>$subMenuList
                ));
            
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

    public function obtenerMenus($iduser){
        $em = $this->getDoctrine()->getManager();            
        $db = $em->getConnection();
        $array = array();
        $menuList = array();
        $subMenuList = array();
        $query = "Select distinct m.* FROM tbl_menus m,
        tbl_perfildetalle pd,
        tbl_perfil p,
        tbl_usuariosperfiles up 
        where up.idusuario = :pIduser
        and pd.idmenu is not null
        and pd.idmenu=m.idmenu
        and p.idperfil=pd.idperfil
        and up. idperfil = p.idperfil
        ORDER BY m.nombremenu ASC";
        $stmt = $db->prepare($query);
        $params = array('pIduser'=>$iduser);
        $stmt->execute($params);
        $menusList=$stmt->fetchAll();

        if($menusList){
            foreach ($menusList as $menuIter) {         

                $emp = $this->getDoctrine()->getManager();
                $dbp = $emp->getConnection();
                $imenu = $menuIter["idmenu"];

                $queryp = "Select * FROM tbl_menus m,
                tbl_menusub sm,
                tbl_perfildetalle pd,
                tbl_perfil p,
                tbl_usuariosperfiles up 
                where up.idusuario= :pIduser
                and m.idmenu = :pImenu
                and pd.idsubmenu is not null
                and sm.idmenu = m.idmenu
                and pd.idmenu=m.idmenu
                and pd.idsubmenu = sm.idsubmenu
                and p.idperfil=pd.idperfil
                and up. idperfil = p.idperfil
                ORDER BY sm.nombresubmenu ASC";
                $stmtp = $dbp->prepare($queryp);
                $paramsp = array('pIduser'=>$iduser,'pImenu'=>$imenu);
                $stmtp->execute($paramsp);
                $subMenu=$stmtp->fetchAll();

                if($subMenu){
                    foreach ($subMenu as $sm) {
                        array_push($subMenuList,$sm);
                    }
                }
                array_push($menuList,$menuIter);
            } 
        }
        array_push($array,$menuList);
        array_push($array,$subMenuList);
        return $array;
    }
}
