<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblEstadoActDet;
use AppBundle\Form\TblEstadoActDetType;

/**
 * TblEstadoActDet controller.
 *
 * @Route("/tblestadoactdet")
 */
class TblEstadoActDetController extends Controller
{
    /**
     * Lists all TblEstadoActDet entities.
     *
     * @Route("/", name="tblestadoactdet_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $tblEstadoActDets = $em->getRepository('AppBundle:TblEstadoActDet')->findAll();

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
                return $this->render('tblestadoactdet/index.html.twig', array(
                    'tblEstadoActDets' => $tblEstadoActDets,
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
     * Creates a new TblEstadoActDet entity.
     *
     * @Route("/new", name="tblestadoactdet_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblEstadoActDet = new TblEstadoActDet();
        $form = $this->createForm('AppBundle\Form\TblEstadoActDetType', $tblEstadoActDet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblEstadoActDet);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../tblestadoactdet'
            window.close()
        </script>";
    }

    return $this->render('tblestadoactdet/new.html.twig', array(
        'tblEstadoActDet' => $tblEstadoActDet,
        'form' => $form->createView(),
        ));
}

    /**
     * Finds and displays a TblEstadoActDet entity.
     *
     * @Route("/{id}", name="tblestadoactdet_show")
     * @Method("GET")
     */
    public function showAction(TblEstadoActDet $tblEstadoActDet)
    {
        $deleteForm = $this->createDeleteForm($tblEstadoActDet);

        return $this->render('tblestadoactdet/show.html.twig', array(
            'tblEstadoActDet' => $tblEstadoActDet,
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * Displays a form to edit an existing TblEstadoActDet entity.
     *
     * @Route("/{id}/edit", name="tblestadoactdet_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblEstadoActDet $tblEstadoActDet)
    {
        $deleteForm = $this->createDeleteForm($tblEstadoActDet);
        $editForm = $this->createForm('AppBundle\Form\TblEstadoActDetType', $tblEstadoActDet);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblEstadoActDet);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../../tblestadoactdet'
            window.close()
        </script>";
    }

    return $this->render('tblestadoactdet/edit.html.twig', array(
        'tblEstadoActDet' => $tblEstadoActDet,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        ));
}

    /**
     * Deletes a TblEstadoActDet entity.
     *
     * @Route("/{id}", name="tblestadoactdet_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblEstadoActDet $tblEstadoActDet)
    {
        $form = $this->createDeleteForm($tblEstadoActDet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblEstadoActDet);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
        window.opener.location='../tblestadoactdet'
        window.close()
    </script>";
}

    /**
     * Creates a form to delete a TblEstadoActDet entity.
     *
     * @param TblEstadoActDet $tblEstadoActDet The TblEstadoActDet entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblEstadoActDet $tblEstadoActDet)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('tblestadoactdet_delete', array('id' => $tblEstadoActDet->getIdestadoactdet())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    /**
     * Finds and displays a TblEstadoActDet entity.
     *
     * @Route("/{id}/sup", name="tblestadoactdet_sup")
     * @Method("GET")
     */
    public function supAction(TblEstadoActDet $tblEstadoActDet)
    {
        $deleteForm = $this->createDeleteForm($tblEstadoActDet);

        return $this->render('tblestadoactdet/sup.html.twig', array(
            'tblEstadoActDet' => $tblEstadoActDet,
            'delete_form' => $deleteForm->createView(),
            ));
    }
}
