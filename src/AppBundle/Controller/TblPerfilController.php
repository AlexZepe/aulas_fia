<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblPerfil;
use AppBundle\Form\TblPerfilType;

/**
 * TblPerfil controller.
 *
 * @Route("/tblperfil")
 */
class TblPerfilController extends Controller
{
    /**
     * Lists all TblPerfil entities.
     *
     * @Route("/", name="tblperfil_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tblPerfils = $em->getRepository('AppBundle:TblPerfil')->findAll();

        $session = $request->getSession();
        if($session->has("id")){
            $em = $this->getDoctrine()->getManager();            
            $db = $em->getConnection();
            $menuList = array();
            $subMenuList = array();
            
            $iduser = $session->get('id');
            $user = $em->getRepository('AppBundle:TblUsuarios')->find($iduser);
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
                return $this->render('tblperfil/index.html.twig', array(
                    'usuariologeado'=>$user,
                    'tblPerfils' => $tblPerfils,
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
     * Creates a new TblPerfil entity.
     *
     * @Route("/new", name="tblperfil_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblPerfil = new TblPerfil();
        $form = $this->createForm('AppBundle\Form\TblPerfilType', $tblPerfil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblPerfil);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../tblperfil'
            window.close()
        </script>";
    }

    return $this->render('tblperfil/new.html.twig', array(
        'tblPerfil' => $tblPerfil,
        'form' => $form->createView(),
        ));
}

    /**
     * Finds and displays a TblPerfil entity.
     *
     * @Route("/{id}", name="tblperfil_show")
     * @Method("GET")
     */
    public function showAction(TblPerfil $tblPerfil)
    {
        $deleteForm = $this->createDeleteForm($tblPerfil);

        return $this->render('tblperfil/show.html.twig', array(
            'tblPerfil' => $tblPerfil,
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * Displays a form to edit an existing TblPerfil entity.
     *
     * @Route("/{id}/edit", name="tblperfil_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblPerfil $tblPerfil)
    {
        $deleteForm = $this->createDeleteForm($tblPerfil);
        $editForm = $this->createForm('AppBundle\Form\TblPerfilType', $tblPerfil);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblPerfil);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../../tblperfil'
            window.close()
        </script>";
    }

    return $this->render('tblperfil/edit.html.twig', array(
        'tblPerfil' => $tblPerfil,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        ));
}

    /**
     * Deletes a TblPerfil entity.
     *
     * @Route("/{id}", name="tblperfil_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblPerfil $tblPerfil)
    {
        $form = $this->createDeleteForm($tblPerfil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblPerfil);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
        window.opener.location='../tblperfil'
        window.close()
    </script>";
}

    /**
     * Creates a form to delete a TblPerfil entity.
     *
     * @param TblPerfil $tblPerfil The TblPerfil entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblPerfil $tblPerfil)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('tblperfil_delete', array('id' => $tblPerfil->getIdperfil())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    /**
     * Finds and displays a TblPerfil entity.
     *
     * @Route("/{id}/sup", name="tblperfil_sup")
     * @Method("GET")
     */
    public function supAction(TblPerfil $tblPerfil)
    {
        $deleteForm = $this->createDeleteForm($tblPerfil);

        return $this->render('tblperfil/sup.html.twig', array(
            'tblPerfil' => $tblPerfil,
            'delete_form' => $deleteForm->createView(),
            ));
    }
}
