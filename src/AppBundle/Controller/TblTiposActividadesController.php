<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblTiposActividades;
use AppBundle\Form\TblTiposActividadesType;

/**
 * TblTiposActividades controller.
 *
 * @Route("/tbltiposactividades")
 */
class TblTiposActividadesController extends Controller
{
    /**
     * Lists all TblTiposActividades entities.
     *
     * @Route("/", name="tbltiposactividades_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tblTiposActividades = $em->getRepository('AppBundle:TblTiposActividades')->findAll();

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
                return $this->render('tbltiposactividades/index.html.twig', array(
                    'tblTiposActividades' => $tblTiposActividades,
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
     * Creates a new TblTiposActividades entity.
     *
     * @Route("/new", name="tbltiposactividades_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblTiposActividade = new TblTiposActividades();
        $form = $this->createForm('AppBundle\Form\TblTiposActividadesType', $tblTiposActividade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblTiposActividade);
            $em->flush();
            

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../tbltiposactividades'
            window.close()
        </script>";

    }

    return $this->render('tbltiposactividades/new.html.twig', array(
        'tblTiposActividade' => $tblTiposActividade,
        'form' => $form->createView(),
        ));
}

    /**
     * Finds and displays a TblTiposActividades entity.
     *
     * @Route("/{id}", name="tbltiposactividades_show")
     * @Method("GET")
     */
    public function showAction(TblTiposActividades $tblTiposActividade)
    {
        $deleteForm = $this->createDeleteForm($tblTiposActividade);

        return $this->render('tbltiposactividades/show.html.twig', array(
            'tblTiposActividade' => $tblTiposActividade,
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * Displays a form to edit an existing TblTiposActividades entity.
     *
     * @Route("/{id}/edit", name="tbltiposactividades_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblTiposActividades $tblTiposActividade)
    {
        $deleteForm = $this->createDeleteForm($tblTiposActividade);
        $editForm = $this->createForm('AppBundle\Form\TblTiposActividadesType', $tblTiposActividade);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblTiposActividade);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../../tbltiposactividades'
            window.close()
        </script>";


            //return $this->redirectToRoute('tbltiposactividades_edit', array('id' => $tblTiposActividade->getIdtipoactividad()));
    }

    return $this->render('tbltiposactividades/edit.html.twig', array(
        'tblTiposActividade' => $tblTiposActividade,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        ));
}

    /**
     * Deletes a TblTiposActividades entity.
     *
     * @Route("/{id}", name="tbltiposactividades_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblTiposActividades $tblTiposActividade)
    {
        $form = $this->createDeleteForm($tblTiposActividade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblTiposActividade);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../tbltiposactividades'
            window.close()
        </script>";

    }


    //return $this->redirectToRoute('tbltiposactividades_index');
}

    /**
     * Creates a form to delete a TblTiposActividades entity.
     *
     * @param TblTiposActividades $tblTiposActividade The TblTiposActividades entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblTiposActividades $tblTiposActividade)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('tbltiposactividades_delete', array('id' => $tblTiposActividade->getIdtipoactividad())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }


    /**
     * Finds and displays a TblTiposActividades entity.
     *
     * @Route("/{id}/sup", name="tbltiposactividades_sup")
     * @Method("GET")
     */
    public function supAction(TblTiposActividades $tblTiposActividade)
    {
        $deleteForm = $this->createDeleteForm($tblTiposActividade);

        return $this->render('tbltiposactividades/sup.html.twig', array(
            'tblTiposActividade' => $tblTiposActividade,
            'delete_form' => $deleteForm->createView(),
            ));
    }

}
