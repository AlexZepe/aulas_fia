<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblMenus;
use AppBundle\Form\TblMenusType;

/**
 * TblMenus controller.
 *
 * @Route("/tblmenus")
 */
class TblMenusController extends Controller
{
    /**
     * Lists all TblMenus entities.
     *
     * @Route("/", name="tblmenus_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tblMenuses = $em->getRepository('AppBundle:TblMenus')->findAll();


        $session = $request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();            
            $db = $em->getConnection();
            $menuList = array();
            $subMenuList = array();
            
            $iduser = $session->get('id');
            $query = "Select * FROM tbl_menus m,
            tbl_perfildetalle pd,
            tbl_perfil p,
            tbl_usuariosperfiles up 
            where up.idusuario=$iduser
            and pd.idmenu is not null
            and pd.idmenu=m.idmenu
            and p.idperfil=pd.idperfil
            and up. idperfil = p.idperfil
            ORDER BY m.nombremenu ASC";
            $stmt = $db->prepare($query);
            $params = array();
            $stmt->execute($params);
            $menusList=$stmt->fetchAll();

            if($menusList){
                foreach ($menusList as $menuIter) {         

                    $emp = $this->getDoctrine()->getManager();            
                    $dbp = $emp->getConnection();
                    
                    $iduser = $session->get('id');
                    $imenu = $menuIter["idmenu"];

                    $queryp = "Select * FROM tbl_menus m,
                    tbl_menusub sm,
                    tbl_perfildetalle pd,
                    tbl_perfil p,
                    tbl_usuariosperfiles up 
                    where up.idusuario=$iduser
                    and m.idmenu =$imenu
                    and pd.idsubmenu is not null
                    and sm.idmenu = m.idmenu
                    and p.idperfil=pd.idperfil
                    and up. idperfil = p.idperfil
                    ORDER BY sm.nombresubmenu ASC";
                    $stmtp = $dbp->prepare($queryp);
                    $paramsp = array();
                    $stmtp->execute($paramsp);
                    $subMenu=$stmtp->fetchAll();

                    if($subMenu){
                        foreach ($subMenu as $sm) {
                            array_push($subMenuList,$sm);
                        }
                    }

                    array_push($menuList,$menuIter);
                }
                return $this->render('tblmenus/index.html.twig', array(
                    'tblMenuses' => $tblMenuses,
                    'menuList'=>$menuList,
                    'subMenuList'=>$subMenuList
                    ));
            }
        }else{
            $this->get("session")->getFlashBag()->add("mensaje","Debe estar logueado para ver este contenido."); 
            return $this->redirect($this->generateUrl("login"));
        }
    }

    /**
     * Creates a new TblMenus entity.
     *
     * @Route("/new", name="tblmenus_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblMenu = new TblMenus();
        $form = $this->createForm('AppBundle\Form\TblMenusType', $tblMenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblMenu);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../tblmenus'
            window.close()
        </script>";
    }

    return $this->render('tblmenus/new.html.twig', array(
        'tblMenu' => $tblMenu,
        'form' => $form->createView(),
        ));
}

    /**
     * Finds and displays a TblMenus entity.
     *
     * @Route("/{id}", name="tblmenus_show")
     * @Method("GET")
     */
    public function showAction(TblMenus $tblMenu)
    {
        $deleteForm = $this->createDeleteForm($tblMenu);

        return $this->render('tblmenus/show.html.twig', array(
            'tblMenu' => $tblMenu,
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * Displays a form to edit an existing TblMenus entity.
     *
     * @Route("/{id}/edit", name="tblmenus_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblMenus $tblMenu)
    {
        $deleteForm = $this->createDeleteForm($tblMenu);
        $editForm = $this->createForm('AppBundle\Form\TblMenusType', $tblMenu);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblMenu);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../../tblmenus'
            window.close()
        </script>";
    }

    return $this->render('tblmenus/edit.html.twig', array(
        'tblMenu' => $tblMenu,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        ));
}

    /**
     * Deletes a TblMenus entity.
     *
     * @Route("/{id}", name="tblmenus_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblMenus $tblMenu)
    {
        $form = $this->createDeleteForm($tblMenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblMenu);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
        window.opener.location='../tblmenus'
        window.close()
    </script>";
}

    /**
     * Creates a form to delete a TblMenus entity.
     *
     * @param TblMenus $tblMenu The TblMenus entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblMenus $tblMenu)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('tblmenus_delete', array('id' => $tblMenu->getIdmenu())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    /**
     * Finds and displays a TblMenus entity.
     *
     * @Route("/{id}/sup", name="tblmenus_sup")
     * @Method("GET")
     */
    public function supAction(TblMenus $tblMenu)
    {
        $deleteForm = $this->createDeleteForm($tblMenu);

        return $this->render('tblmenus/sup.html.twig', array(
            'tblMenu' => $tblMenu,
            'delete_form' => $deleteForm->createView(),
            ));
    }
}
