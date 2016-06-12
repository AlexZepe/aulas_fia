<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\TblCursos;
use AppBundle\Form\TblCursosType;
use AppBundle\Entity\TblActividadesDetalle;
use AppBundle\Form\TblActividadesDetalleType;

class CursosController extends Controller
{
    public function saveActividadAction(Request $request, $idCurso){

        $maxIdActt = $this->getDoctrine()->getEntityManager()->createQuery("SELECT max(a.idactividad) maxidactividad from AppBundle:TblActividades a")->getResult();
        
        $maxIdAct = $maxIdActt[0]["maxidactividad"];
        $maxIdAct = $maxIdAct + 1;

        $maxIdActDett = $this->getDoctrine()->getEntityManager()->createQuery("SELECT max(ad.idactividadesdetalle) maxidactividaddet from AppBundle:TblActividadesDetalle ad")->getResult();
        
        $maxIdActDet = $maxIdActDett[0]["maxidactividaddet"];
        $maxIdActDet = $maxIdActDet + 1;

        $idEstadoActDet = $this->getDoctrine()->getEntityManager()->createQuery("SELECT ead.idestadoactdet from AppBundle:TblEstadoActDet ead where ead.nombreestadoactdet = 'Pendiente de Aprobación Escuela'")->getResult();

        $this->getDoctrine()->getManager()->getConnection()->insert('Tbl_Actividades',array('idactividad'=>$maxIdAct,'idtipoactividad'=>$request->get("tiposActividadSelect"),'idcurso'=>$idCurso));

        $fechaActividad = null;
        $fechainicioAct = null;
        if($request->get("fechaInicioInput")){
            $fechainicioAct = $request->get("fechaInicioInput");
            $fechaActividad = $request->get("fechaInicioInput");
        }
        $fechafinAct = null;
        if($request->get("fechaFinInput")){
            $fechafinAct = $request->get("fechaFinInput");
        }
        if($request->get("fechaActividadInput")){
            $fechaActividad = $request->get("fechaActividadInput");
        }

        $this->getDoctrine()->getManager()->getConnection()->insert('Tbl_Actividades_Detalle',array('idactividadesdetalle'=>$maxIdActDet,'idactividad'=>$maxIdAct,'idestadoactdet'=>$idEstadoActDet[0]["idestadoactdet"],'idaula'=>$request->get("aulaSelect"),'horainicio'=>$request->get("horaInicioActSelect"),'horafin'=>$request->get("horaFinActSelect"),'dia'=>$fechaActividad,'correlativo'=>$request->get("numActividadInput"),'estado'=>$idEstadoActDet[0]["idestadoactdet"],'fechainicio'=>$fechainicioAct,'fechafin'=>$fechafinAct));
        
        $infoCicloArray = $this->obtenerInfoCiclo($idCurso);
        $infoCiclo = $infoCicloArray[0];

        $actividadesList = $this->getDoctrine()->getEntityManager()->createQuery("SELECT a.idactividad
            ,ta.nombretipoactividad
            ,ad.correlativo
            ,ead.nombreestadoactdet 
            from AppBundle:TblActividades a
            ,AppBundle:TblActividadesDetalle ad 
            ,AppBundle:TblTiposActividades ta 
            ,AppBundle:TblEstadoActDet ead
            where a.idcurso = :pIdCurso
            and ad.idactividad = a.idactividad
            and ta.idtipoactividad = a.idtipoactividad
            and ead.idestadoactdet = ad.idestadoactdet")->setParameters(array('pIdCurso'=>$idCurso))->getResult();

        return $this->render('AppBundle:Cursos:gestionarActividades.html.twig',array('infoCiclo'=>$infoCiclo,'idCur'=>$idCurso,'actividadesList'=>$actividadesList));     
    }

    public function gestionarActividadesAddAction(Request $request,$idCurso){
        $tblActividadesDetalle = new TblActividadesDetalle();
        $form = $this->createForm('AppBundle\Form\TblActividadesDetalleType', $tblActividadesDetalle);
        $form->handleRequest($request);

        /*$tblPerfil = new TblPerfil();
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
        ));*/

        $infoCicloArray = $this->obtenerInfoCiclo($idCurso);
        $infoCiclo = $infoCicloArray[0];

        $tblTiposActividades = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblTiposActividades')->findAll();

        $tblAulas = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblAulas')->findAll();

        return $this->render('AppBundle:Cursos:gestionarActividadesAdd.html.twig',array('infoCiclo'=>$infoCiclo,'idCur'=>$idCurso,'tiposActividadesList'=>$tblTiposActividades,'aulasList'=>$tblAulas,'form' => $form->createView()));
    }

    public function findEscuelasAction(Request $request){
        $db = $this->getDoctrine()->getManager()->getConnection();
        $escuelasList = array();
        $query = "SELECT e.idescuela,e.nombreescuela,e.siglasescuela
        from tbl_escuelas e";
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        $escuelasList=$stmt->fetchAll();

        return $this->render('AppBundle:Cursos:nuevoCurso.html.twig', array(
            'escuelasList' => $escuelasList
        ));

    }

    public function newCursoSaveAction(Request $request){
        $maxIdCursoo = $this->getDoctrine()->getEntityManager()->createQuery("SELECT max(c.idcurso) maxIdCurso from AppBundle:TblCursos c")->getResult();

        $maxIdCurso = $maxIdCursoo[0]["maxIdCurso"];
        $maxIdCurso = $maxIdCurso + 1; 

        $this->getDoctrine()->getManager()->getConnection()->insert('Tbl_Cursos',array('idcurso'=>$maxIdCurso,'idmateria'=>$request->get("materiaSelect"),'idCiclo'=>$request->get("cicloSelect"),'nombrecurso'=>""));

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
            
            $facultades = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblFacultades')->findAll();

            $escuelas = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblEscuelas')->findAll();

            $ciclosList = $this->obtenerCiclosList();
            $cursosList = $this->obtenerCursosList($request,0);

            return $this->render('AppBundle:Cursos:cursos.html.twig', array('usuariologeado'=>$user,
                'menuList'=>$menuList,
                'subMenuList'=>$subMenuList,
                'facultades'=>$facultades,
                'escuelas'=>$escuelas,
                'ciclosList'=>$ciclosList,
                'cursosList'=>$cursosList));
        }else{
            $this->get("session")->getFlashBag()->add("mensaje","Debe estar logueado para ver este contenido."); 
               return $this->redirect($this->generateUrl("login"));
        }
        return $this->render('AppBundle:Cursos:cursos.html.twig');
    }

    public function newCursoAction(Request $request){            
        $ciclosList = $this->obtenerCiclosList();

        $materiasList = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblMaterias')->findAll();

        return $this->render('AppBundle:Cursos:nuevoCurso.html.twig', array(
            'ciclosList' => $ciclosList,
            'materiasList' => $materiasList
        ));
    }

    public function deleteCursoDocenteAction(Request $request){
        $idCursoDocente = $request->query->get('idCursoDocente');
        $idCurso = $request->query->get('idCurso');

        $db = $this->getDoctrine()->getManager()->getConnection();
        $sql = "DELETE FROM Tbl_Cursos_Docentes 
        WHERE idCursoDocente = ?";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $idCursoDocente);
        $stmt->execute();

        $infoCicloArray = $this->obtenerInfoCiclo($idCurso);
        if($infoCicloArray){
            $infoCiclo = $infoCicloArray[0];
        }else{
            $infoCiclo = "";
        }

        $cursoDocentes = $this->getDoctrine()->getEntityManager()->createQuery("SELECT cd from AppBundle:TblCursosDocentes cd
            ,AppBundle:TblCursos c 
            ,AppBundle:TblEmpleados emp 
            where cd.idcurso = :pIdCurso
            and c.idcurso = cd.idcurso
            and emp.idempleado = cd.idempleado")->setParameters(array('pIdCurso'=>$idCurso))->getResult();

        return $this->render('AppBundle:Cursos:gestionarDocentes.html.twig',array('infoCiclo'=>$infoCiclo,'docentesList'=>$cursoDocentes,'idCur'=>$idCurso));
    }

    public function editCursoDocenteAction(Request $request){
         $idCursoDocente = $request->query->get('idCursoDocente');
         $idCurso = $request->query->get('idCurso');

        $db = $this->getDoctrine()->getManager()->getConnection();
        $sql = "UPDATE Tbl_Cursos_Docentes 
        set cargo = ?
        ,idcurso = ?
        ,idempleado = ?
        WHERE idCursoDocente = ?";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $request->get("rolEnCursoSelect"));
        $stmt->bindValue(2, $idCurso);
        $stmt->bindValue(3, $request->get("empleadoSelect"));
        $stmt->bindValue(4, $idCursoDocente);
        $stmt->execute();

        $infoCicloArray = $this->obtenerInfoCiclo($idCurso);
        if($infoCicloArray){
            $infoCiclo = $infoCicloArray[0];
        }else{
            $infoCiclo = "";
        }

        $cursoDocentes = $this->getDoctrine()->getEntityManager()->createQuery("SELECT cd from AppBundle:TblCursosDocentes cd
            ,AppBundle:TblCursos c 
            ,AppBundle:TblEmpleados emp 
            where cd.idcurso = :pIdCurso
            and c.idcurso = cd.idcurso
            and emp.idempleado = cd.idempleado")->setParameters(array('pIdCurso'=>$idCurso))->getResult();

        return $this->render('AppBundle:Cursos:gestionarDocentes.html.twig',array('infoCiclo'=>$infoCiclo,'docentesList'=>$cursoDocentes,'idCur'=>$idCurso)); 
    }

    public function saveCursoDocenteAction(Request $request, $idCurso){
        $maxId = $this->getDoctrine()->getEntityManager()->createQuery("SELECT max(cd.idcursodocente) maxidcursodocente from AppBundle:TblCursosDocentes cd")->getResult();
        
        $maxIdAux = $maxId[0]["maxidcursodocente"];
        $maxIdAux = $maxIdAux + 1;

        $this->getDoctrine()->getManager()->getConnection()->insert('Tbl_Cursos_Docentes',array('idcursodocente'=>$maxIdAux,'cargo'=>$request->get("rolEnCursoSelect"),'idcurso'=>$idCurso,'idempleado'=>$request->get("empleadoSelect")));

        $infoCicloArray = $this->obtenerInfoCiclo($idCurso);
        $infoCiclo = $infoCicloArray[0];

        $cursoDocentes = $this->getDoctrine()->getEntityManager()->createQuery("SELECT cd from AppBundle:TblCursosDocentes cd
            ,AppBundle:TblCursos c 
            ,AppBundle:TblEmpleados emp 
            where cd.idcurso = :pIdCurso
            and c.idcurso = cd.idcurso
            and emp.idempleado = cd.idempleado")->setParameters(array('pIdCurso'=>$idCurso))->getResult();

        return $this->render('AppBundle:Cursos:gestionarDocentes.html.twig',array('infoCiclo'=>$infoCiclo,'docentesList'=>$cursoDocentes,'idCur'=>$idCurso));

    }

    public function gestionarDocentesDeleteAction(Request $request, $idCursoDocente){
        $empleadosList = $this->getDoctrine()->getEntityManager()->createQuery("SELECT emp from AppBundle:TblEmpleados emp
            ,AppBundle:TblPuestos p
            where p.nombrepuesto = 'Catedrático'
            and p.idpuesto = emp.idpuesto")->getResult();

        $cursoDocente = $this->getDoctrine()->getEntityManager()->createQuery("SELECT cd from AppBundle:TblCursosDocentes cd where cd.idcursodocente = :pIdCursoDocente")->setParameters(array('pIdCursoDocente'=>$idCursoDocente))->getResult();

        $idCurso = $cursoDocente[0]->getIdCurso()->getIdCurso(); 
        $infoCicloArray = $this->obtenerInfoCiclo($idCurso);
        $infoCiclo = $infoCicloArray[0];
        
        return $this->render('AppBundle:Cursos:gestionarDocentesDelete.html.twig',array('infoCiclo'=>$infoCiclo,'idCur'=>$idCurso,'empleadosList'=>$empleadosList,'idCursoDocente'=>$idCursoDocente,'cursoDocente'=>$cursoDocente));
    }

    public function gestionarDocentesEditAction(Request $request, $idCursoDocente){
        
        $empleadosList = $this->getDoctrine()->getEntityManager()->createQuery("SELECT emp from AppBundle:TblEmpleados emp
            ,AppBundle:TblPuestos p
            where p.nombrepuesto = 'Catedrático'
            and p.idpuesto = emp.idpuesto")->getResult();

        $cursoDocente = $this->getDoctrine()->getEntityManager()->createQuery("SELECT cd from AppBundle:TblCursosDocentes cd where cd.idcursodocente = :pIdCursoDocente")->setParameters(array('pIdCursoDocente'=>$idCursoDocente))->getResult();

        $idCurso = $cursoDocente[0]->getIdCurso()->getIdCurso(); 
        $infoCicloArray = $this->obtenerInfoCiclo($idCurso);
        $infoCiclo = $infoCicloArray[0];

        return $this->render('AppBundle:Cursos:gestionarDocentesEdit.html.twig',array('infoCiclo'=>$infoCiclo,'idCur'=>$idCurso,'empleadosList'=>$empleadosList,'idCursoDocente'=>$idCursoDocente,'cursoDocente'=>$cursoDocente));
    }

    public function gestionarDocentesAddAction(Request $request, $idCurso){
        $infoCicloArray = $this->obtenerInfoCiclo($idCurso);
        $infoCiclo = $infoCicloArray[0];

        $empleadosList = $this->getDoctrine()->getEntityManager()->createQuery("SELECT emp from AppBundle:TblEmpleados emp
            ,AppBundle:TblPuestos p
            where p.nombrepuesto = 'Catedrático'
            and p.idpuesto = emp.idpuesto")->getResult(); 

        return $this->render('AppBundle:Cursos:gestionarDocentesAdd.html.twig',array('infoCiclo'=>$infoCiclo,'idCur'=>$idCurso,'empleadosList'=>$empleadosList));
    }

    public function gestionarDocentesAction($idCurso){
        $infoCicloArray = $this->obtenerInfoCiclo($idCurso);
        $infoCiclo = $infoCicloArray[0];

        $cursoDocentes = $this->getDoctrine()->getEntityManager()->createQuery("SELECT cd from AppBundle:TblCursosDocentes cd
            ,AppBundle:TblCursos c 
            ,AppBundle:TblEmpleados emp 
            where cd.idcurso = :pIdCurso
            and c.idcurso = cd.idcurso
            and emp.idempleado = cd.idempleado")->setParameters(array('pIdCurso'=>$idCurso))->getResult();

        return $this->render('AppBundle:Cursos:gestionarDocentes.html.twig',array('infoCiclo'=>$infoCiclo,'docentesList'=>$cursoDocentes,'idCur'=>$idCurso));
    }

    public function gestionarActividadesAction(Request $request,$idCurso){
        $infoCicloArray = $this->obtenerInfoCiclo($idCurso);
        $infoCiclo = $infoCicloArray[0];

        $actividadesList = $this->getDoctrine()->getEntityManager()->createQuery("SELECT a.idactividad
            ,ta.nombretipoactividad
            ,ad.correlativo
            ,ead.nombreestadoactdet 
            from AppBundle:TblActividades a
            ,AppBundle:TblActividadesDetalle ad 
            ,AppBundle:TblTiposActividades ta 
            ,AppBundle:TblEstadoActDet ead
            where a.idcurso = :pIdCurso
            and ad.idactividad = a.idactividad
            and ta.idtipoactividad = a.idtipoactividad
            and ead.idestadoactdet = ad.idestadoactdet")->setParameters(array('pIdCurso'=>$idCurso))->getResult();

        return $this->render('AppBundle:Cursos:gestionarActividades.html.twig',array('infoCiclo'=>$infoCiclo,'idCur'=>$idCurso,'actividadesList'=>$actividadesList));
    }

    public function salirAction(Request $request)
    {
        $session = $request->getSession();
        $session->clear();
        $this->get("session")->getFlashBag()->add("mensaje","Se ha cerrado sesión exitosamente.");
        return $this->render('AppBundle:Login:login.html.twig');
    }

    public function obtenerMenus($iduser){
        $em = $this->getDoctrine()->getManager();            
        $db = $em->getConnection();
        $array = array();
        $menuList = array();
        $subMenuList = array();
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
                    and pd.idmenu=m.idmenu
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
        }
        array_push($array,$menuList);
        array_push($array,$subMenuList);
        return $array;
    }

    public function obtenerCursosList(Request $request, $find){
        $db = $this->getDoctrine()->getManager()->getConnection();
        $query = "";
        if($find == 0){
            $query = "
select t.idcurso,t.idmateria, t.idciclo, t.nombremateria,
t.siglasfacultad, t.siglasescuela, t.aniociclo, t.numerociclo  
from (
SELECT row_number() OVER (ORDER BY cic.aniociclo,cic.numerociclo) AS i,
c.idcurso,c.idmateria,c.idciclo,m.nombremateria,
f.siglasfacultad,e.siglasescuela,cic.aniociclo, cic.numerociclo 
from Tbl_Cursos c
,Tbl_Ciclos cic
,Tbl_Materias m
,Tbl_Escuelas e
,Tbl_Facultades f
where cic.idciclo = c.idciclo
and m.idmateria = c.idmateria
and e.idescuela = m.idescuela
and f.idfacultad = e.idfacultad
order by cic.aniociclo,cic.numerociclo desc) as t
where t.i <= 10";
        }else{

            $pIdFacultad = $request->get("facultadSelect");
            $pIdEscuela = $request->get("escuelaSelect");
            $pIdCiclo = $request->get("cicloSelect");

            $query = "
select t.idcurso,t.idmateria, t.idciclo, t.nombremateria,
t.siglasfacultad, t.siglasescuela, t.aniociclo, t.numerociclo  
from (
SELECT row_number() OVER (ORDER BY cic.aniociclo,cic.numerociclo) AS i,
c.idcurso,c.idmateria,c.idciclo,m.nombremateria,
f.siglasfacultad,e.siglasescuela,cic.aniociclo, cic.numerociclo 
from Tbl_Cursos c
,Tbl_Ciclos cic
,Tbl_Materias m
,Tbl_Escuelas e
,Tbl_Facultades f
where cic.idciclo = c.idciclo
and m.idmateria = c.idmateria
and e.idescuela = m.idescuela
and f.idfacultad = e.idfacultad
and f.idfacultad = $pIdFacultad
and e.idescuela = $pIdEscuela
and cic.idciclo = $pIdCiclo
order by cic.aniociclo,cic.numerociclo desc) as t
where t.i <= 10";
        }
        $stmt = $db->prepare($query);
        $params = array();
        $stmt->execute($params);
        return $stmt->fetchAll();
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

    public function obtenerInfoCiclo($idCurso){
        $array = array();
        $infoCiclo = $this->getDoctrine()->getEntityManager()->createQuery("SELECT f.nombrefacultad,
            e.nombreescuela,
            cic.aniociclo,
            cic.numerociclo,
            m.nombremateria,
            f.idfacultad,
            e.idescuela,
            cic.aniociclo,
            cic.numerociclo
            from AppBundle:TblCursos c
            ,AppBundle:TblCiclos cic
            ,AppBundle:TblMaterias m
            ,AppBundle:TblEscuelas e
            ,AppBundle:TblFacultades f
            where cic.idciclo = c.idciclo
            and m.idmateria = c.idmateria
            and e.idescuela = m.idescuela
            and f.idfacultad = e.idfacultad
            and c.idcurso = :pIdCurso")->setParameters(array('pIdCurso'=>$idCurso))->getResult();

        $infCiclo = "";
        $idfac=null;
        $idEsc=null;
        $anioCic=null;
        $numCic=null;
        if($infoCiclo){
            $infCiclo .= $infoCiclo[0]["nombrefacultad"];
            $infCiclo .= " -> ";
            $infCiclo .= $infoCiclo[0]["nombreescuela"];
            $infCiclo .= " -> ";
            $infCiclo .= $infoCiclo[0]["nombremateria"];
            $infCiclo .= " -> Ciclo ";
            $infCiclo .= $infoCiclo[0]["numerociclo"];
            $infCiclo .= " ";
            $infCiclo .= $infoCiclo[0]["aniociclo"];

            array_push($array,$infCiclo);
            array_push($array,$infoCiclo[0]["idfacultad"]);
            array_push($array,$infoCiclo[0]["idescuela"]);
            array_push($array,$infoCiclo[0]["aniociclo"]);
            array_push($array,$infoCiclo[0]["numerociclo"]);
        }
        return $array;
    }

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
            
            $facultades = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblFacultades')->findAll();

            $escuelas = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblEscuelas')->findAll();

            $ciclosList = $this->obtenerCiclosList();
            $cursosList = $this->obtenerCursosList($request,0);

            return $this->render('AppBundle:Cursos:cursos.html.twig', array('usuariologeado'=>$user,
                'menuList'=>$menuList,
                'subMenuList'=>$subMenuList,
                'facultades'=>$facultades,
                'escuelas'=>$escuelas,
                'ciclosList'=>$ciclosList,
                'cursosList'=>$cursosList));
        }else{
            $this->get("session")->getFlashBag()->add("mensaje","Debe estar logueado para ver este contenido."); 
               return $this->redirect($this->generateUrl("login"));
        }
        return $this->render('AppBundle:Cursos:cursos.html.twig');
    }

    public function findCursosAction(Request $request){
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();            
        $db = $em->getConnection();
        $menuList = array();
        $subMenuList = array();

        $iduser = $session->get('id');
        $user = $em->getRepository('AppBundle:TblUsuarios')->find($iduser);
        $array = $this->obtenerMenus($iduser);
        $menuList = $array[0];
        $subMenuList = $array[1];
            
        $facultades = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblFacultades')->findAll();

        $escuelas = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblEscuelas')->findAll();

        $ciclosList = $this->obtenerCiclosList();
        $cursosList = $this->obtenerCursosList($request,1);

        return $this->render('AppBundle:Cursos:cursos.html.twig', 
            array('usuariologeado'=>$user,
                'menuList'=>$menuList,
                'subMenuList'=>$subMenuList,
                'facultades'=>$facultades,
                'escuelas'=>$escuelas,
                'ciclosList'=>$ciclosList,
                'cursosList'=>$cursosList)); 
    }
}