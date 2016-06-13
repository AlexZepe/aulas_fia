<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblTiposAulas;
use AppBundle\Form\TblTiposAulasType;

/**
 * TblTiposAulas controller.
 *
 * @Route("/tbltiposaulas")
 */
class TblTiposAulasController extends Controller
{
    /**
     * Lists all TblTiposAulas entities.
     *
     * @Route("/", name="tbltiposaulas_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $tblTiposAulas = $em->getRepository('AppBundle:TblTiposAulas')->findAll();            
            $db = $em->getConnection();
            $menuList = array();
            $subMenuList = array();
            
            $iduser = $session->get('id');
            $user = $em->getRepository('AppBundle:TblUsuarios')->find($iduser);

            $array = $this->obtenerMenus($iduser);
            $menuList = $array[0];
            $subMenuList = $array[1];
            
            return $this->render('tbltiposaulas/index.html.twig', array(
                'usuariologeado'=>$user,
                'tblTiposAulas' => $tblTiposAulas,
                'menuList'=>$menuList,
                'subMenuList'=>$subMenuList
                ));
            
        }else{
            $this->get("session")->getFlashBag()->add("mensaje","Debe estar logueado para ver este contenido."); 
            return $this->redirect($this->generateUrl("login"));
        }
    }

    /**
     * Creates a new TblTiposAulas entity.
     *
     * @Route("/new", name="tbltiposaulas_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblTiposAula = new TblTiposAulas();
        $form = $this->createForm('AppBundle\Form\TblTiposAulasType', $tblTiposAula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblTiposAula);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../tbltiposaulas'
            window.close()
        </script>";
    }

    return $this->render('tbltiposaulas/new.html.twig', array(
        'tblTiposAula' => $tblTiposAula,
        'form' => $form->createView(),
        ));
}

    /**
     * Finds and displays a TblTiposAulas entity.
     *
     * @Route("/{id}", name="tbltiposaulas_show")
     * @Method("GET")
     */
    public function showAction(TblTiposAulas $tblTiposAula)
    {
        $deleteForm = $this->createDeleteForm($tblTiposAula);

        return $this->render('tbltiposaulas/show.html.twig', array(
            'tblTiposAula' => $tblTiposAula,
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * Displays a form to edit an existing TblTiposAulas entity.
     *
     * @Route("/{id}/edit", name="tbltiposaulas_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblTiposAulas $tblTiposAula)
    {
        $deleteForm = $this->createDeleteForm($tblTiposAula);
        $editForm = $this->createForm('AppBundle\Form\TblTiposAulasType', $tblTiposAula);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblTiposAula);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../../tbltiposaulas'
            window.close()
        </script>";
    }

    return $this->render('tbltiposaulas/edit.html.twig', array(
        'tblTiposAula' => $tblTiposAula,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        ));
}

    /**
     * Deletes a TblTiposAulas entity.
     *
     * @Route("/{id}", name="tbltiposaulas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblTiposAulas $tblTiposAula)
    {
        $form = $this->createDeleteForm($tblTiposAula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblTiposAula);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
        window.opener.location='../tbltiposaulas'
        window.close()
    </script>";
}

    /**
     * Creates a form to delete a TblTiposAulas entity.
     *
     * @param TblTiposAulas $tblTiposAula The TblTiposAulas entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblTiposAulas $tblTiposAula)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('tbltiposaulas_delete', array('id' => $tblTiposAula->getIdtipoaula())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    /**
     * Finds and displays a TblTiposAulas entity.
     *
     * @Route("/{id}/sup", name="tbltiposaulas_sup")
     * @Method("GET")
     */
    public function supAction(TblTiposAulas $tblTiposAula)
    {
        $deleteForm = $this->createDeleteForm($tblTiposAula);

        return $this->render('tbltiposaulas/sup.html.twig', array(
            'tblTiposAula' => $tblTiposAula,
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
