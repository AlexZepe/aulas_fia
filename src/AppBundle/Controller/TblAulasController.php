<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblAulas;
use AppBundle\Form\TblAulasType;
use AppBundle\Controller\IndexController;

/**
 * TblAulas controller.
 *
 * @Route("/tblaulas")
 */
class TblAulasController extends Controller
{
    /**
     * Lists all TblAulas entities.
     *
     * @Route("/", name="tblaulas_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tblAulas = $em->getRepository('AppBundle:TblAulas')->findAll();

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
                return $this->render('tblaulas/index.html.twig', array(
                    'tblAulas' => $tblAulas,
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
     * Creates a new TblAulas entity.
     *
     * @Route("/new", name="tblaulas_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblAula = new TblAulas();
        $form = $this->createForm('AppBundle\Form\TblAulasType', $tblAula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblAula);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../tblaulas'
            window.close()
        </script>";
    }

    return $this->render('tblaulas/new.html.twig', array(
        'tblAula' => $tblAula,
        'form' => $form->createView(),
        ));
}

    /**
     * Finds and displays a TblAulas entity.
     *
     * @Route("/{id}", name="tblaulas_show")
     * @Method("GET")
     */
    public function showAction(TblAulas $tblAula)
    {
        $deleteForm = $this->createDeleteForm($tblAula);

        return $this->render('tblaulas/show.html.twig', array(
            'tblAula' => $tblAula,
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * Displays a form to edit an existing TblAulas entity.
     *
     * @Route("/{id}/edit", name="tblaulas_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblAulas $tblAula)
    {
        $deleteForm = $this->createDeleteForm($tblAula);
        $editForm = $this->createForm('AppBundle\Form\TblAulasType', $tblAula);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblAula);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../../tblaulas'
            window.close()
        </script>";
    }

    return $this->render('tblaulas/edit.html.twig', array(
        'tblAula' => $tblAula,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        ));
}

    /**
     * Deletes a TblAulas entity.
     *
     * @Route("/{id}", name="tblaulas_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblAulas $tblAula)
    {
        $form = $this->createDeleteForm($tblAula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblAula);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
        window.opener.location='../tblaulas'
        window.close()
    </script>";
}

    /**
     * Creates a form to delete a TblAulas entity.
     *
     * @param TblAulas $tblAula The TblAulas entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblAulas $tblAula)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('tblaulas_delete', array('id' => $tblAula->getIdaula())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    /**
     * Finds and displays a TblAulas entity.
     *
     * @Route("/{id}/sup", name="tblaulas_sup")
     * @Method("GET")
     */
    public function supAction(TblAulas $tblAula)
    {
        $deleteForm = $this->createDeleteForm($tblAula);

        return $this->render('tblaulas/sup.html.twig', array(
            'tblAula' => $tblAula,
            'delete_form' => $deleteForm->createView(),
            ));
    }
}
