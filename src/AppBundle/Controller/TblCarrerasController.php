<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblCarreras;
use AppBundle\Form\TblCarrerasType;

/**
 * TblCarreras controller.
 *
 * @Route("/tblcarreras")
 */
class TblCarrerasController extends Controller
{
    /**
     * Lists all TblCarreras entities.
     *
     * @Route("/", name="tblcarreras_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();            
            $db = $em->getConnection();
            $menuList = array();
            $subMenuList = array();
            
            $iduser = $session->get('id');
            $user = $em->getRepository('AppBundle:TblUsuarios')->find($iduser);
            $array = $this->obtenerMenus($iduser);
            $menuList = $array[0];
            $subMenuList = $array[1];

            $tblCarreras = $em->getRepository('AppBundle:TblCarreras')->findAll();
             
            return $this->render('tblcarreras/index.html.twig', array(
                    'usuariologeado'=>$user,
                    'tblCarreras' => $tblCarreras,
                    'menuList'=>$menuList,
                    'subMenuList'=>$subMenuList));
        }else{
            $this->get("session")->getFlashBag()->add("mensaje","Debe estar logueado para ver este contenido."); 
            return $this->redirect($this->generateUrl("login"));
        }

    }

    /**
     * Creates a new TblCarreras entity.
     *
     * @Route("/new", name="tblcarreras_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblCarrera = new TblCarreras();
        $form = $this->createForm('AppBundle\Form\TblCarrerasType', $tblCarrera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblCarrera);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../tblcarreras'
            window.close()
        </script>";
    }

    return $this->render('tblcarreras/new.html.twig', array(
        'tblCarrera' => $tblCarrera,
        'form' => $form->createView(),
        ));
}

    /**
     * Finds and displays a TblCarreras entity.
     *
     * @Route("/{id}", name="tblcarreras_show")
     * @Method("GET")
     */
    public function showAction(TblCarreras $tblCarrera)
    {
        $deleteForm = $this->createDeleteForm($tblCarrera);

        return $this->render('tblcarreras/show.html.twig', array(
            'tblCarrera' => $tblCarrera,
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * Displays a form to edit an existing TblCarreras entity.
     *
     * @Route("/{id}/edit", name="tblcarreras_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblCarreras $tblCarrera)
    {
        $deleteForm = $this->createDeleteForm($tblCarrera);
        $editForm = $this->createForm('AppBundle\Form\TblCarrerasType', $tblCarrera);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblCarrera);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../../tblcarreras'
            window.close()
        </script>";
    }

    return $this->render('tblcarreras/edit.html.twig', array(
        'tblCarrera' => $tblCarrera,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        ));
}

    /**
     * Deletes a TblCarreras entity.
     *
     * @Route("/{id}", name="tblcarreras_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblCarreras $tblCarrera)
    {
        $form = $this->createDeleteForm($tblCarrera);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblCarrera);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
        window.opener.location='../tblcarreras'
        window.close()
    </script>";
}

    /**
     * Creates a form to delete a TblCarreras entity.
     *
     * @param TblCarreras $tblCarrera The TblCarreras entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblCarreras $tblCarrera)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('tblcarreras_delete', array('id' => $tblCarrera->getIdcarrera())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    /**
     * Finds and displays a TblCarreras entity.
     *
     * @Route("/{id}/sup", name="tblcarreras_sup")
     * @Method("GET")
     */
    public function supAction(TblCarreras $tblCarrera)
    {
        $deleteForm = $this->createDeleteForm($tblCarrera);

        return $this->render('tblcarreras/sup.html.twig', array(
            'tblCarrera' => $tblCarrera,
            'delete_form' => $deleteForm->createView(),
            ));
    }

    public function obtenerMenus($iduser){
        $em = $this->getDoctrine()->getManager();            
        $db = $em->getConnection();
        $array = array();
        $menuList = array();
        $subMenuList = array();
        $query = "Select * FROM tbl_menus m,
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
