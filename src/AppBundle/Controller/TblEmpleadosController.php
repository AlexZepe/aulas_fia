<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblEmpleados;
use AppBundle\Form\TblEmpleadosType;

/**
 * TblEmpleados controller.
 *
 * @Route("/tblempleados")
 */
class TblEmpleadosController extends Controller
{
    /**
     * Lists all TblEmpleados entities.
     *
     * @Route("/", name="tblempleados_index")
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

            $tblEmpleados = $em->getRepository('AppBundle:TblEmpleados')->findAll();

            return $this->render('tblempleados/index.html.twig', array(
                    'usuariologeado'=>$user,
                    'tblEmpleados' => $tblEmpleados,
                    'menuList'=>$menuList,
                    'subMenuList'=>$subMenuList
                    ));
        }else{
            $this->get("session")->getFlashBag()->add("mensaje","Debe estar logueado para ver este contenido."); 
            return $this->redirect($this->generateUrl("login"));
        }

    }

    /**
     * Creates a new TblEmpleados entity.
     *
     * @Route("/new", name="tblempleados_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblEmpleado = new TblEmpleados();
        $form = $this->createForm('AppBundle\Form\TblEmpleadosType', $tblEmpleado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblEmpleado);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../tblempleados'
            window.close()
        </script>";
    }

    return $this->render('tblempleados/new.html.twig', array(
        'tblEmpleado' => $tblEmpleado,
        'form' => $form->createView(),
        ));
}

    /**
     * Finds and displays a TblEmpleados entity.
     *
     * @Route("/{id}", name="tblempleados_show")
     * @Method("GET")
     */
    public function showAction(TblEmpleados $tblEmpleado)
    {
        $deleteForm = $this->createDeleteForm($tblEmpleado);

        return $this->render('tblempleados/show.html.twig', array(
            'tblEmpleado' => $tblEmpleado,
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * Displays a form to edit an existing TblEmpleados entity.
     *
     * @Route("/{id}/edit", name="tblempleados_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblEmpleados $tblEmpleado)
    {
        $deleteForm = $this->createDeleteForm($tblEmpleado);
        $editForm = $this->createForm('AppBundle\Form\TblEmpleadosType', $tblEmpleado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblEmpleado);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../../tblempleados'
            window.close()
        </script>";
    }

    return $this->render('tblempleados/edit.html.twig', array(
        'tblEmpleado' => $tblEmpleado,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        ));
}

    /**
     * Deletes a TblEmpleados entity.
     *
     * @Route("/{id}", name="tblempleados_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblEmpleados $tblEmpleado)
    {
        $form = $this->createDeleteForm($tblEmpleado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblEmpleado);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
        window.opener.location='../tblempleados'
        window.close()
    </script>";
}

    /**
     * Creates a form to delete a TblEmpleados entity.
     *
     * @param TblEmpleados $tblEmpleado The TblEmpleados entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblEmpleados $tblEmpleado)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('tblempleados_delete', array('id' => $tblEmpleado->getIdempleado())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    /**
     * Finds and displays a TblEmpleados entity.
     *
     * @Route("/{id}/sup", name="tblempleados_sup")
     * @Method("GET")
     */
    public function supAction(TblEmpleados $tblEmpleado)
    {
        $deleteForm = $this->createDeleteForm($tblEmpleado);

        return $this->render('tblempleados/sup.html.twig', array(
            'tblEmpleado' => $tblEmpleado,
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
