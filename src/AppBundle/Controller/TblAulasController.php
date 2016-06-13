<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblAulas;
use AppBundle\Entity\TblEstadoActDet;
use AppBundle\Form\TblAulasType;
use AppBundle\Controller\IndexController;
use AppBundle\Controller\CursosController;

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

            $tblAulas = $em->getRepository('AppBundle:TblAulas')->findAll();
            
            return $this->render('tblaulas/index.html.twig', array(
                    'usuariologeado'=>$user,
                    'tblAulas' => $tblAulas,
                    'menuList'=>$menuList,
                    'subMenuList'=>$subMenuList
                    ));
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

    public function consultaDisponibilidadInitAction(Request $request){
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

            $aulasList = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblAulas')->findAll();

            $estadosActDetList = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblEstadoActDet')->findAll();

            $ciclosList = $this->obtenerCiclosList();

            return $this->render('AppBundle:Aulas:consultaDisponibilidadAulas.html.twig',array('aulasList'=>$aulasList,
            'estadosActDetList'=>$estadosActDetList,
            'ciclosList'=>$ciclosList,
            'solicitudesList'=>null,
            'usuariologeado'=>$user,
            'menuList'=>$menuList,
            'subMenuList'=>$subMenuList));
        }else{
            $this->get("session")->getFlashBag()->add("mensaje","Debe estar logueado para ver este contenido."); 
            return $this->redirect($this->generateUrl("login"));
        } 
    }

    public function consultaDisponibilidadAction(Request $request){
        $idAula = $request->get("aulaSelect");
        $idCiclo = $request->get("cicloSelect");
        $idEstadoActDet = $request->get("estadoActDetSelect");

        $em = $this->getDoctrine()->getManager();
        $db = $em->getConnection();            
        $query = 
"SELECT a.hora_inicio, a.hora_fin, y.lunes, d.martes,g.miercoles,j.jueves,m.viernes,p.sabado,s.domingo from (

SELECT '06:20' hora_inicio,'08:00' hora_fin 
union
SELECT '08:05' hora_inicio,'09:45' hora_fin 
union
SELECT '09:50' hora_inicio,'11:30' hora_fin
union
SELECT '11:35' hora_inicio,'13:15' hora_fin
union
SELECT '13:20' hora_inicio,'15:00' hora_fin 
union
SELECT '15:05' hora_inicio,'16:45' hora_fin 
union
SELECT '16:50' hora_inicio,'18:30' hora_fin
union
SELECT '18:35' hora_inicio,'20:15' hora_fin) as a

left join ( 

select x.HORAINICIO,x.HORAFIN,x.LUNES from(
select w.HORAINICIO,w.HORAFIN,w.CODIGOMATERIA LUNES
from (

SELECT M.NOMBREMATERIA,M.CODIGOMATERIA,TACT.NOMBRETIPOACTIVIDAD,ACTD.CORRELATIVO,
(select case extract(dow from ACTD.DIA)
when 1 then 'LUNES'
when 2 then 'MARTES'
when 3 then 'MIERCOLES'
when 4 then 'JUEVES'
when 5 then 'VIERNES'
when 6 then 'SABADO'
else ' DOMINGO' 
end) dia,

ACTD.HORAINICIO,ACTD.HORAFIN 
FROM TBL_CURSOS C
INNER JOIN TBL_MATERIAS M ON M.IDMATERIA = C.IDMATERIA
INNER JOIN TBL_CICLOS CIC ON CIC.IDCICLO = C.IDCICLO
INNER JOIN TBL_CURSOS CUR ON CUR.IDCICLO = C.IDCICLO
AND CUR.IDMATERIA = M.IDMATERIA
INNER JOIN TBL_ACTIVIDADES ACT ON ACT.IDCURSO = CUR.IDCURSO
INNER JOIN TBL_ACTIVIDADES_DETALLE ACTD ON ACTD.IDACTIVIDAD = ACT.IDACTIVIDAD
INNER JOIN TBL_TIPOS_ACTIVIDADES TACT ON TACT.IDTIPOACTIVIDAD = ACT.IDTIPOACTIVIDAD
inner join TBL_AULAS tau on tau.IDAULA = ACTD.IDAULA
where actd.idestadoactdet = :pIdEstadoActDet
and tau.idaula = :pIdAula
and cic.idCiclo = :pIdCiclo
ORDER BY ACTD.DIA,ACTD.horaInicio,TACT.nombreTipoActividad,ACTD.CORRELATIVO
) w
WHERE W.DIA = 'LUNES') x) y on y.horainicio = a.hora_inicio and y.horafin = a.hora_fin

left join ( 

select C.HORAINICIO,C.HORAFIN,C.MARTES from(
select b.HORAINICIO,b.HORAFIN,B.CODIGOMATERIA MARTES
from (

SELECT M.NOMBREMATERIA,M.CODIGOMATERIA,TACT.NOMBRETIPOACTIVIDAD,ACTD.CORRELATIVO,
(select case extract(dow from ACTD.DIA)
when 1 then 'LUNES'
when 2 then 'MARTES'
when 3 then 'MIERCOLES'
when 4 then 'JUEVES'
when 5 then 'VIERNES'
when 6 then 'SABADO'
else ' DOMINGO' 
end) dia,

ACTD.HORAINICIO,ACTD.HORAFIN 
FROM TBL_CURSOS C
INNER JOIN TBL_MATERIAS M ON M.IDMATERIA = C.IDMATERIA
INNER JOIN TBL_CICLOS CIC ON CIC.IDCICLO = C.IDCICLO
INNER JOIN TBL_CURSOS CUR ON CUR.IDCICLO = C.IDCICLO
AND CUR.IDMATERIA = M.IDMATERIA
INNER JOIN TBL_ACTIVIDADES ACT ON ACT.IDCURSO = CUR.IDCURSO
INNER JOIN TBL_ACTIVIDADES_DETALLE ACTD ON ACTD.IDACTIVIDAD = ACT.IDACTIVIDAD
INNER JOIN TBL_TIPOS_ACTIVIDADES TACT ON TACT.IDTIPOACTIVIDAD = ACT.IDTIPOACTIVIDAD
inner join TBL_AULAS tau on tau.IDAULA = ACTD.IDAULA
where actd.idestadoactdet = :pIdEstadoActDet
and tau.idaula = :pIdAula
and cic.idCiclo = :pIdCiclo
ORDER BY ACTD.DIA,ACTD.horaInicio,TACT.nombreTipoActividad,ACTD.CORRELATIVO
) b
WHERE b.DIA = 'MARTES') c) d on d.horainicio = a.hora_inicio and d.horafin = a.hora_fin

left join ( 

select f.HORAINICIO,F.HORAFIN,f.MIERCOLES from(
select e.HORAINICIO,e.HORAFIN,e.CODIGOMATERIA MIERCOLES
from (

SELECT M.NOMBREMATERIA,M.CODIGOMATERIA,TACT.NOMBRETIPOACTIVIDAD,ACTD.CORRELATIVO,
(select case extract(dow from ACTD.DIA)
when 1 then 'LUNES'
when 2 then 'MARTES'
when 3 then 'MIERCOLES'
when 4 then 'JUEVES'
when 5 then 'VIERNES'
when 6 then 'SABADO'
else ' DOMINGO' 
end) dia,

ACTD.HORAINICIO,ACTD.HORAFIN 
FROM TBL_CURSOS C
INNER JOIN TBL_MATERIAS M ON M.IDMATERIA = C.IDMATERIA
INNER JOIN TBL_CICLOS CIC ON CIC.IDCICLO = C.IDCICLO
INNER JOIN TBL_CURSOS CUR ON CUR.IDCICLO = C.IDCICLO
AND CUR.IDMATERIA = M.IDMATERIA
INNER JOIN TBL_ACTIVIDADES ACT ON ACT.IDCURSO = CUR.IDCURSO
INNER JOIN TBL_ACTIVIDADES_DETALLE ACTD ON ACTD.IDACTIVIDAD = ACT.IDACTIVIDAD
INNER JOIN TBL_TIPOS_ACTIVIDADES TACT ON TACT.IDTIPOACTIVIDAD = ACT.IDTIPOACTIVIDAD
inner join TBL_AULAS tau on tau.IDAULA = ACTD.IDAULA
where actd.idestadoactdet = :pIdEstadoActDet
and tau.idaula = :pIdAula
and cic.idCiclo = :pIdCiclo
ORDER BY ACTD.DIA,ACTD.horaInicio,TACT.nombreTipoActividad,ACTD.CORRELATIVO
) e
WHERE e.DIA = 'MIERCOLES') f) g on G.horainicio = a.hora_inicio and g.horafin = a.hora_fin

left join ( 

select i.HORAINICIO,i.HORAFIN,i.jueves from(
select h.HORAINICIO,h.HORAFIN,h.CODIGOMATERIA jueves
from (

SELECT M.NOMBREMATERIA,M.CODIGOMATERIA,TACT.NOMBRETIPOACTIVIDAD,ACTD.CORRELATIVO,
(select case extract(dow from ACTD.DIA)
when 1 then 'LUNES'
when 2 then 'MARTES'
when 3 then 'MIERCOLES'
when 4 then 'JUEVES'
when 5 then 'VIERNES'
when 6 then 'SABADO'
else ' DOMINGO' 
end) dia,

ACTD.HORAINICIO,ACTD.HORAFIN 
FROM TBL_CURSOS C
INNER JOIN TBL_MATERIAS M ON M.IDMATERIA = C.IDMATERIA
INNER JOIN TBL_CICLOS CIC ON CIC.IDCICLO = C.IDCICLO
INNER JOIN TBL_CURSOS CUR ON CUR.IDCICLO = C.IDCICLO
AND CUR.IDMATERIA = M.IDMATERIA
INNER JOIN TBL_ACTIVIDADES ACT ON ACT.IDCURSO = CUR.IDCURSO
INNER JOIN TBL_ACTIVIDADES_DETALLE ACTD ON ACTD.IDACTIVIDAD = ACT.IDACTIVIDAD
INNER JOIN TBL_TIPOS_ACTIVIDADES TACT ON TACT.IDTIPOACTIVIDAD = ACT.IDTIPOACTIVIDAD
inner join TBL_AULAS tau on tau.IDAULA = ACTD.IDAULA
where actd.idestadoactdet = :pIdEstadoActDet
and tau.idaula = :pIdAula
and cic.idCiclo = :pIdCiclo
ORDER BY ACTD.DIA,ACTD.horaInicio,TACT.nombreTipoActividad,ACTD.CORRELATIVO
) h
WHERE h.DIA = 'JUEVES') i) j on j.horainicio = a.hora_inicio and j.horafin = a.hora_fin

left join ( 

select l.HORAINICIO,l.HORAFIN,l.viernes from(
select k.HORAINICIO,k.HORAFIN,k.CODIGOMATERIA viernes
from (

SELECT M.NOMBREMATERIA,M.CODIGOMATERIA,TACT.NOMBRETIPOACTIVIDAD,ACTD.CORRELATIVO,
(select case extract(dow from ACTD.DIA)
when 1 then 'LUNES'
when 2 then 'MARTES'
when 3 then 'MIERCOLES'
when 4 then 'JUEVES'
when 5 then 'VIERNES'
when 6 then 'SABADO'
else ' DOMINGO' 
end) dia,

ACTD.HORAINICIO,ACTD.HORAFIN 
FROM TBL_CURSOS C
INNER JOIN TBL_MATERIAS M ON M.IDMATERIA = C.IDMATERIA
INNER JOIN TBL_CICLOS CIC ON CIC.IDCICLO = C.IDCICLO
INNER JOIN TBL_CURSOS CUR ON CUR.IDCICLO = C.IDCICLO
AND CUR.IDMATERIA = M.IDMATERIA
INNER JOIN TBL_ACTIVIDADES ACT ON ACT.IDCURSO = CUR.IDCURSO
INNER JOIN TBL_ACTIVIDADES_DETALLE ACTD ON ACTD.IDACTIVIDAD = ACT.IDACTIVIDAD
INNER JOIN TBL_TIPOS_ACTIVIDADES TACT ON TACT.IDTIPOACTIVIDAD = ACT.IDTIPOACTIVIDAD
inner join TBL_AULAS tau on tau.IDAULA = ACTD.IDAULA
where actd.idestadoactdet = :pIdEstadoActDet
and tau.idaula = :pIdAula
and cic.idCiclo = :pIdCiclo
ORDER BY ACTD.DIA,ACTD.horaInicio,TACT.nombreTipoActividad,ACTD.CORRELATIVO
) k
WHERE k.DIA = 'VIERNES') l) m on m.horainicio = a.hora_inicio and m.horafin = a.hora_fin

left join ( 

select o.HORAINICIO,o.HORAFIN,o.sabado from(
select n.HORAINICIO,n.HORAFIN,n.CODIGOMATERIA sabado
from (

SELECT M.NOMBREMATERIA,M.CODIGOMATERIA,TACT.NOMBRETIPOACTIVIDAD,ACTD.CORRELATIVO,
(select case extract(dow from ACTD.DIA)
when 1 then 'LUNES'
when 2 then 'MARTES'
when 3 then 'MIERCOLES'
when 4 then 'JUEVES'
when 5 then 'VIERNES'
when 6 then 'SABADO'
else ' DOMINGO' 
end) dia,

ACTD.HORAINICIO,ACTD.HORAFIN 
FROM TBL_CURSOS C
INNER JOIN TBL_MATERIAS M ON M.IDMATERIA = C.IDMATERIA
INNER JOIN TBL_CICLOS CIC ON CIC.IDCICLO = C.IDCICLO
INNER JOIN TBL_CURSOS CUR ON CUR.IDCICLO = C.IDCICLO
AND CUR.IDMATERIA = M.IDMATERIA
INNER JOIN TBL_ACTIVIDADES ACT ON ACT.IDCURSO = CUR.IDCURSO
INNER JOIN TBL_ACTIVIDADES_DETALLE ACTD ON ACTD.IDACTIVIDAD = ACT.IDACTIVIDAD
INNER JOIN TBL_TIPOS_ACTIVIDADES TACT ON TACT.IDTIPOACTIVIDAD = ACT.IDTIPOACTIVIDAD
inner join TBL_AULAS tau on tau.IDAULA = ACTD.IDAULA
where actd.idestadoactdet = :pIdEstadoActDet
and tau.idaula = :pIdAula
and cic.idCiclo = :pIdCiclo
ORDER BY ACTD.DIA,ACTD.horaInicio,TACT.nombreTipoActividad,ACTD.CORRELATIVO
) n
WHERE n.DIA = 'SABADO') o) p on p.horainicio = a.hora_inicio and p.horafin = a.hora_fin

left join ( 

select R.HORAINICIO,R.HORAFIN,R.domingo from(
select Q.HORAINICIO,Q.HORAFIN,Q.CODIGOMATERIA domingo
from (

SELECT M.NOMBREMATERIA,M.CODIGOMATERIA,TACT.NOMBRETIPOACTIVIDAD,ACTD.CORRELATIVO,
(select case extract(dow from ACTD.DIA)
when 1 then 'LUNES'
when 2 then 'MARTES'
when 3 then 'MIERCOLES'
when 4 then 'JUEVES'
when 5 then 'VIERNES'
when 6 then 'SABADO'
else ' DOMINGO' 
end) dia,

ACTD.HORAINICIO,ACTD.HORAFIN 
FROM TBL_CURSOS C
INNER JOIN TBL_MATERIAS M ON M.IDMATERIA = C.IDMATERIA
INNER JOIN TBL_CICLOS CIC ON CIC.IDCICLO = C.IDCICLO
INNER JOIN TBL_CURSOS CUR ON CUR.IDCICLO = C.IDCICLO
AND CUR.IDMATERIA = M.IDMATERIA
INNER JOIN TBL_ACTIVIDADES ACT ON ACT.IDCURSO = CUR.IDCURSO
INNER JOIN TBL_ACTIVIDADES_DETALLE ACTD ON ACTD.IDACTIVIDAD = ACT.IDACTIVIDAD
INNER JOIN TBL_TIPOS_ACTIVIDADES TACT ON TACT.IDTIPOACTIVIDAD = ACT.IDTIPOACTIVIDAD
inner join TBL_AULAS tau on tau.IDAULA = ACTD.IDAULA
where actd.idestadoactdet = :pIdEstadoActDet
and tau.idaula = :pIdAula
and cic.idCiclo = :pIdCiclo
ORDER BY ACTD.DIA,ACTD.horaInicio,TACT.nombreTipoActividad,ACTD.CORRELATIVO
) Q
WHERE Q.DIA = 'DOMINGO') R) s on s.horainicio = a.hora_inicio and S.horafin = a.hora_fin
order by a.hora_inicio, a.hora_fin";
        $stmt = $db->prepare($query);
        $params = array('pIdEstadoActDet'=>$idEstadoActDet,'pIdAula'=>$idAula,'pIdCiclo'=>$idCiclo);
        $stmt->execute($params);
        $solicitudesList = $stmt->fetchAll();

        $aulasList = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblAulas')->findAll();

        $estadosActDetList = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblEstadoActDet')->findAll();

        $menuList = array();
        $subMenuList = array();

        $session = $request->getSession();
        $ciclosList = $this->obtenerCiclosList();
        $iduser = $session->get('id');
        $user = $em->getRepository('AppBundle:TblUsuarios')->find($iduser);

        $array = $this->obtenerMenus($iduser);
        $menuList = $array[0];
        $subMenuList = $array[1];

        return $this->render('AppBundle:Aulas:consultaDisponibilidadAulas.html.twig',array('aulasList'=>$aulasList,
            'estadosActDetList'=>$estadosActDetList,
            'ciclosList'=>$ciclosList,
            'solicitudesList'=>$solicitudesList,
            'usuariologeado'=>$user,
            'menuList'=>$menuList,
            'subMenuList'=>$subMenuList));
    }

    public function obtenerCiclosList(){
        $db = $this->getDoctrine()->getManager()->getConnection();
        $query = "select t.idciclo, t.aniociclo, t.numerociclo from(
        SELECT row_number() OVER (ORDER BY aniociclo,numerociclo) AS i, 
        c.idciclo, c.aniociclo, c.numerociclo 
        from tbl_ciclos c 
        order by aniociclo,numerociclo desc) as t
        where t.i <= 10";
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        return $stmt->fetchAll();
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
