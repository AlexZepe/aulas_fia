<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblMaterias;
use AppBundle\Form\TblMateriasType;

/**
 * TblMaterias controller.
 *
 * @Route("/tblmaterias")
 */
class TblMateriasController extends Controller
{
    /**
     * Lists all TblMaterias entities.
     *
     * @Route("/", name="tblmaterias_index")
     * @Method("GET")
     */
    public function indexAction( Request $request)
    {
     

        $session = $request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();
            $tblMaterias = $em->getRepository('AppBundle:TblMaterias')->findAll();            
            $db = $em->getConnection();
            $menuList = array();
            $subMenuList = array();
            
            $iduser = $session->get('id');
            $user = $em->getRepository('AppBundle:TblUsuarios')->find($iduser);

            $array = $this->obtenerMenus($iduser);
            $menuList = $array[0];
            $subMenuList = $array[1];
            
            return $this->render('tblmaterias/index.html.twig', array(
                'usuariologeado'=>$user,
                'tblMaterias' => $tblMaterias,
                'menuList'=>$menuList,
                'subMenuList'=>$subMenuList
                ));
            

        }else{
            $this->get("session")->getFlashBag()->add("mensaje","Debe estar logueado para ver este contenido."); 
            return $this->redirect($this->generateUrl("login"));
        }
    }

    /**
     * Creates a new TblMaterias entity.
     *
     * @Route("/new", name="tblmaterias_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblMateria = new TblMaterias();
        $form = $this->createForm('AppBundle\Form\TblMateriasType', $tblMateria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblMateria);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../tblmaterias'
            window.close()
        </script>";
    }

    return $this->render('tblmaterias/new.html.twig', array(
        'tblMateria' => $tblMateria,
        'form' => $form->createView(),
        ));
}

    /**
     * Finds and displays a TblMaterias entity.
     *
     * @Route("/{id}", name="tblmaterias_show")
     * @Method("GET")
     */
    public function showAction(TblMaterias $tblMateria)
    {
        $deleteForm = $this->createDeleteForm($tblMateria);

        return $this->render('tblmaterias/show.html.twig', array(
            'tblMateria' => $tblMateria,
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * Displays a form to edit an existing TblMaterias entity.
     *
     * @Route("/{id}/edit", name="tblmaterias_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblMaterias $tblMateria)
    {
        $deleteForm = $this->createDeleteForm($tblMateria);
        $editForm = $this->createForm('AppBundle\Form\TblMateriasType', $tblMateria);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblMateria);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../../tblmaterias'
            window.close()
        </script>";
    }

    return $this->render('tblmaterias/edit.html.twig', array(
        'tblMateria' => $tblMateria,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        ));
}

    /**
     * Deletes a TblMaterias entity.
     *
     * @Route("/{id}", name="tblmaterias_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblMaterias $tblMateria)
    {
        $form = $this->createDeleteForm($tblMateria);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblMateria);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
        window.opener.location='../tblmaterias'
        window.close()
    </script>";
}

    /**
     * Creates a form to delete a TblMaterias entity.
     *
     * @param TblMaterias $tblMateria The TblMaterias entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblMaterias $tblMateria)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('tblmaterias_delete', array('id' => $tblMateria->getIdmateria())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    /**
     * Finds and displays a TblMaterias entity.
     *
     * @Route("/{id}/sup", name="tblmaterias_sup")
     * @Method("GET")
     */
    public function supAction(TblMaterias $tblMateria)
    {
        $deleteForm = $this->createDeleteForm($tblMateria);

        return $this->render('tblmaterias/sup.html.twig', array(
            'tblMateria' => $tblMateria,
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
