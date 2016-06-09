<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblUsuarios;
use AppBundle\Form\TblUsuariosType;
use AppBundle\Form\TblUsuariosPerfilType;
use AppBundle\Entity\TblPerfil;

/**
 * TblUsuarios controller.
 *
 * @Route("/tblusuarios")
 */
class TblUsuariosController extends Controller
{
    /**
     * Lists all TblUsuarios entities.
     *
     * @Route("/", name="tblusuarios_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tblUsuarios = $em->getRepository('AppBundle:TblUsuarios')->findAll();

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
                return $this->render('tblusuarios/index.html.twig', array(
                    'tblUsuarios' => $tblUsuarios,
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
     * Creates a new TblUsuarios entity.
     *
     * @Route("/new", name="tblusuarios_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblUsuario = new TblUsuarios();
        $form = $this->createForm('AppBundle\Form\TblUsuariosType', $tblUsuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $data = $form->getData();
            $password = $data->getPassword();
            $encoder = $this->container->get('security.password_encoder');
            $encod = $encoder->encodePassword($tblUsuario, $password);
            $tblUsuario->setPassword($encod);

            $tblUsuario->setVigencia(1);
            $tblUsuario->setEstatus(1);
            $tblUsuario->setFechaestatus($tblUsuario->getFechaalta());

            $em = $this->getDoctrine()->getManager();
            $em->persist($tblUsuario);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../tblusuarios'
            window.close()
        </script>";
    }

    return $this->render('tblusuarios/new.html.twig', array(
        'tblUsuario' => $tblUsuario,
        'form' => $form->createView(),
        ));
}

    /**
     * Finds and displays a TblUsuarios entity.
     *
     * @Route("/{id}", name="tblusuarios_show")
     * @Method("GET")
     */
    public function showAction(TblUsuarios $tblUsuario)
    {
        $deleteForm = $this->createDeleteForm($tblUsuario);

        return $this->render('tblusuarios/show.html.twig', array(
            'tblUsuario' => $tblUsuario,
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * Displays a form to edit an existing TblUsuarios entity.
     *
     * @Route("/{id}/edit", name="tblusuarios_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblUsuarios $tblUsuario)
    {
        $deleteForm = $this->createDeleteForm($tblUsuario);
        $editForm = $this->createForm('AppBundle\Form\TblUsuariosType', $tblUsuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $data = $editForm->getData();
            $password = $data->getPassword();
            $encoder = $this->container->get('security.password_encoder');
            $encod = $encoder->encodePassword($tblUsuario, $password);
            $tblUsuario->setPassword($encod);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblUsuario);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../../tblusuarios'
            window.close()
        </script>";
    }

    return $this->render('tblusuarios/edit.html.twig', array(
        'tblUsuario' => $tblUsuario,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        ));
}

    /**
     * Deletes a TblUsuarios entity.
     *
     * @Route("/{id}", name="tblusuarios_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblUsuarios $tblUsuario)
    {
        $form = $this->createDeleteForm($tblUsuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblUsuario);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
        window.opener.location='../tblusuarios'
        window.close()
    </script>";
}

    /**
     * Creates a form to delete a TblUsuarios entity.
     *
     * @param TblUsuarios $tblUsuario The TblUsuarios entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblUsuarios $tblUsuario)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('tblusuarios_delete', array('id' => $tblUsuario->getIdusuario())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    /**
     * Finds and displays a TblUsuarios entity.
     *
     * @Route("/{id}/sup", name="tblusuarios_sup")
     * @Method("GET")
     */
    public function supAction(TblUsuarios $tblUsuario)
    {
        $deleteForm = $this->createDeleteForm($tblUsuario);

        return $this->render('tblusuarios/sup.html.twig', array(
            'tblUsuario' => $tblUsuario,
            'delete_form' => $deleteForm->createView(),
            ));
    }


    /**
     * Finds and displays a TblUsuarios entity.
     *
     * @Route("/{id}/vper", name="tblusuarios_vper")
     * @Method("GET")
     */
    public function vperAction(TblUsuarios $tblUsuario)
    {
        $deleteForm = $this->createDeleteForm($tblUsuario);
        $vperForm = $this->createForm('AppBundle\Form\TblUsuariosPerfilType', $tblUsuario);


        return $this->render('tblusuarios/vper.html.twig', array(
            'tblUsuario' => $tblUsuario,
            'vperForm' => $deleteForm->createView(),
            ));
    }

    /**
     * Displays a form to edit an existing TblUsuarios entity.
     *
     * @Route("/{id}/aper", name="tblusuarios_aper")
     * @Method({"GET", "POST"})
     */
    public function aperAction(Request $request, TblUsuarios $tblUsuario)
    {
        $deleteForm = $this->createDeleteForm($tblUsuario);
        $editForm = $this->createForm('AppBundle\Form\TblUsuariosType', $tblUsuario);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $db = $em->getConnection();

            $query = "delete FROM tbl_usuariosperfiles where idusuario=".$tblUsuario->getIdusuario().";";
            $stmt = $db->prepare($query);
            $params = array();
            $stmt->execute($params);
            $po=$stmt->fetchAll();

            $perfiles = $tblUsuario->getIdperfil();

            foreach($perfiles as $id){
                $perfil = $em->getRepository('AppBundle:TblPerfil')->find($id); 
                $tblUsuario->addIdperfil($perfil); 
                $em->persist($tblUsuario);
            }

            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../../tblusuarios'
            window.close()
        </script>";
        
    }

    return $this->render('tblusuarios/aper.html.twig', array(
        'tblUsuario' => $tblUsuario,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        ));
}
}
