<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblCiclos;
use AppBundle\Form\TblCiclosType;

/**
 * TblCiclos controller.
 *
 * @Route("/tblciclos")
 */
class TblCiclosController extends Controller
{
    /**
     * Lists all TblCiclos entities.
     *
     * @Route("/", name="tblciclos_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $tblCiclos = $em->getRepository('AppBundle:TblCiclos')->findAll();

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
                return $this->render('tblciclos/index.html.twig', array(
                    'usuariologeado'=>$user,
                    'tblCiclos' => $tblCiclos,
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
     * Creates a new TblCiclos entity.
     *
     * @Route("/new", name="tblciclos_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $tblCiclo = new TblCiclos();
        $form = $this->createForm('AppBundle\Form\TblCiclosType', $tblCiclo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblCiclo);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../tblciclos'
            window.close()
        </script>";
    }

    return $this->render('tblciclos/new.html.twig', array(
        'tblCiclo' => $tblCiclo,
        'form' => $form->createView(),
        ));
}

    /**
     * Finds and displays a TblCiclos entity.
     *
     * @Route("/{id}", name="tblciclos_show")
     * @Method("GET")
     */
    public function showAction(TblCiclos $tblCiclo)
    {
        $deleteForm = $this->createDeleteForm($tblCiclo);

        return $this->render('tblciclos/show.html.twig', array(
            'tblCiclo' => $tblCiclo,
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * Displays a form to edit an existing TblCiclos entity.
     *
     * @Route("/{id}/edit", name="tblciclos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, TblCiclos $tblCiclo)
    {
        $deleteForm = $this->createDeleteForm($tblCiclo);
        $editForm = $this->createForm('AppBundle\Form\TblCiclosType', $tblCiclo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($tblCiclo);
            $em->flush();

            echo "<script language='Javascript' type='text/javascript'>
            window.opener.location='../../tblciclos'
            window.close()
        </script>";
    }

    return $this->render('tblciclos/edit.html.twig', array(
        'tblCiclo' => $tblCiclo,
        'edit_form' => $editForm->createView(),
        'delete_form' => $deleteForm->createView(),
        ));
}

    /**
     * Deletes a TblCiclos entity.
     *
     * @Route("/{id}", name="tblciclos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, TblCiclos $tblCiclo)
    {
        $form = $this->createDeleteForm($tblCiclo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($tblCiclo);
            $em->flush();
        }

        echo "<script language='Javascript' type='text/javascript'>
        window.opener.location='../tblciclos'
        window.close()
    </script>";
}

    /**
     * Creates a form to delete a TblCiclos entity.
     *
     * @param TblCiclos $tblCiclo The TblCiclos entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TblCiclos $tblCiclo)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('tblciclos_delete', array('id' => $tblCiclo->getIdciclo())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    /**
     * Finds and displays a TblCiclos entity.
     *
     * @Route("/{id}/sup", name="tblciclos_sup")
     * @Method("GET")
     */
    public function supAction(TblCiclos $tblCiclo)
    {
        $deleteForm = $this->createDeleteForm($tblCiclo);

        return $this->render('tblciclos/sup.html.twig', array(
            'tblCiclo' => $tblCiclo,
            'delete_form' => $deleteForm->createView(),
            ));
    }
}
