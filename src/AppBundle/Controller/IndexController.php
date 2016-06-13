<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class IndexController extends Controller
{

    public function inicioAction(Request $request)
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

            return $this->render('default/index.html.twig', array(
                'usuariologeado'=>$user,
                'menuList'=>$menuList,
                'subMenuList'=>$subMenuList
            ));       
    }else{
      $this->get("session")->getFlashBag()->add("mensaje","Debe estar logueado para ver este contenido."); 
      return $this->redirect($this->generateUrl("login"));
  }
}

public function salirAction(Request $request)
{
    $session = $request->getSession();
    $session->clear();
    $this->get("session")->getFlashBag()->add("mensaje","Se ha cerrado sesión exitosamente.");
    return $this->render('AppBundle:Login:login.html.twig');
        //return $this->redirect($this->generateUrl("login"));
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