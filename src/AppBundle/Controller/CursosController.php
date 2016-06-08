<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class CursosController extends Controller
{

    public function newAction(Request $request){
        return $this->render('AppBundle:Cursos:nuevoCurso.html.twig');
    }

    public function saveActividadAction(Request $request, $idCurso){
        $maxIdActt = $this->getDoctrine()->getEntityManager()->createQuery("SELECT max(a.idactividad) maxidactividad from AppBundle:TblActividades a")->getResult();
        
        $maxIdAct = $maxIdActt[0]["maxidactividad"];
        $maxIdAct = $maxIdAct + 1;

        $maxIdActDett = $this->getDoctrine()->getEntityManager()->createQuery("SELECT max(ad.idactividadesdetalle) maxidactividaddet from AppBundle:TblActividadesDetalle ad")->getResult();
        
        $maxIdActDet = $maxIdActDett[0]["maxidactividaddet"];
        $maxIdActDet = $maxIdActDet + 1;

        $idEstadoActDet = $this->getDoctrine()->getEntityManager()->createQuery("SELECT ead.idestadoactdet from AppBundle:TblEstadoActDet ead where ead.nombreestadoactdet = 'Pendiente de Aprobación'")->getResult();

        $this->getDoctrine()->getManager()->getConnection()->insert('Tbl_Actividades',array('idactividad'=>$maxIdAct,'idtipoactividad'=>$request->get("tiposActividadSelect"),'idcurso'=>$idCurso));

        $this->getDoctrine()->getManager()->getConnection()->insert('Tbl_Actividades_Detalle',array('idactividadesdetalle'=>$maxIdActDet,'idactividad'=>$maxIdAct,'idestadoactdet'=>$idEstadoActDet[0]["idestadoactdet"],'idaula'=>$request->get("aulaSelect"),'horainicio'=>$request->get("horaInicioActSelect"),'horafin'=>$request->get("horaFinActSelect"),'dia'=>$request->get("fechaActividadInput"),'correlativo'=>$request->get("numActividadInput"),'estado'=>$idEstadoActDet[0]["idestadoactdet"]));
        
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

            $idfac=$infoCiclo[0]["idfacultad"];
            $idEsc=$infoCiclo[0]["idescuela"];
            $anioCic=$infoCiclo[0]["aniociclo"];
            $numCic=$infoCiclo[0]["numerociclo"];
        }

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

        return $this->render('AppBundle:Cursos:gestionarActividades.html.twig',array('infoCiclo'=>$infCiclo,'idCur'=>$idCurso,'idfac'=>null,'idEsc'=>null,'anioCic'=>null,'numCic'=>null,'actividadesList'=>$actividadesList));
               
    }

    public function saveCursoDocenteAction(Request $request, $idCurso){
        $maxId = $this->getDoctrine()->getEntityManager()->createQuery("SELECT max(cd.idcursodocente) maxidcursodocente from AppBundle:TblCursosDocentes cd")->getResult();
        
        $maxIdAux = $maxId[0]["maxidcursodocente"];
        $maxIdAux = $maxIdAux + 1;

        $this->getDoctrine()->getManager()->getConnection()->insert('Tbl_Cursos_Docentes',array('idcursodocente'=>$maxIdAux,'cargo'=>$request->get("rolEnCursoSelect"),'idcurso'=>$idCurso,'idempleado'=>$request->get("empleadoSelect")));

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

            $idfac=$infoCiclo[0]["idfacultad"];
            $idEsc=$infoCiclo[0]["idescuela"];
            $anioCic=$infoCiclo[0]["aniociclo"];
            $numCic=$infoCiclo[0]["numerociclo"];
        }

        $cursoDocentes = $this->getDoctrine()->getEntityManager()->createQuery("SELECT cd from AppBundle:TblCursosDocentes cd
            ,AppBundle:TblCursos c 
            ,AppBundle:TblEmpleados emp 
            where cd.idcurso = :pIdCurso
            and c.idcurso = cd.idcurso
            and emp.idempleado = cd.idempleado")->setParameters(array('pIdCurso'=>$idCurso))->getResult();

        return $this->render('AppBundle:Cursos:gestionarDocentes.html.twig',array('infoCiclo'=>$infCiclo,'docentesList'=>$cursoDocentes,'idCur'=>$idCurso,'idfac'=>$idfac,'idEsc'=>$idEsc,'anioCic'=>$anioCic,'numCic'=>$numCic));

    }

    public function gestionarDocentesAddAction(Request $request, $idCurso){
        $infoCiclo = $this->getDoctrine()->getEntityManager()->createQuery("SELECT f.nombrefacultad,
            e.nombreescuela,
            cic.aniociclo,
            cic.numerociclo,
            m.nombremateria
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
        }

        $empleadosList = $this->getDoctrine()->getEntityManager()->createQuery("SELECT emp from AppBundle:TblEmpleados emp
            ,AppBundle:TblPuestos p
            where p.nombrepuesto = 'Docente'
            and p.idpuesto = emp.idpuesto")->getResult(); 

        return $this->render('AppBundle:Cursos:gestionarDocentesAdd.html.twig',array('infoCiclo'=>$infCiclo,'idCur'=>$idCurso,'empleadosList'=>$empleadosList));
    }

    public function gestionarDocentesAction($idCurso){
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

            $idfac=$infoCiclo[0]["idfacultad"];
            $idEsc=$infoCiclo[0]["idescuela"];
            $anioCic=$infoCiclo[0]["aniociclo"];
            $numCic=$infoCiclo[0]["numerociclo"];
        }

        $cursoDocentes = $this->getDoctrine()->getEntityManager()->createQuery("SELECT cd from AppBundle:TblCursosDocentes cd
            ,AppBundle:TblCursos c 
            ,AppBundle:TblEmpleados emp 
            where cd.idcurso = :pIdCurso
            and c.idcurso = cd.idcurso
            and emp.idempleado = cd.idempleado")->setParameters(array('pIdCurso'=>$idCurso))->getResult();

        return $this->render('AppBundle:Cursos:gestionarDocentes.html.twig',array('infoCiclo'=>$infCiclo,'docentesList'=>$cursoDocentes,'idCur'=>$idCurso,'idfac'=>$idfac,'idEsc'=>$idEsc,'anioCic'=>$anioCic,'numCic'=>$numCic));
    }

    public function gestionarActividadesAddAction(Request $request,$idCurso){
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

            $idfac=$infoCiclo[0]["idfacultad"];
            $idEsc=$infoCiclo[0]["idescuela"];
            $anioCic=$infoCiclo[0]["aniociclo"];
            $numCic=$infoCiclo[0]["numerociclo"];
        }

        $tblTiposActividades = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblTiposActividades')->findAll();

        $tblAulas = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblAulas')->findAll();

        return $this->render('AppBundle:Cursos:gestionarActividadesAdd.html.twig',array('infoCiclo'=>$infCiclo,'idCur'=>$idCurso,'tiposActividadesList'=>$tblTiposActividades,'aulasList'=>$tblAulas));
    }

    public function gestionarActividadesAction(Request $request,$idCurso){
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

            $idfac=$infoCiclo[0]["idfacultad"];
            $idEsc=$infoCiclo[0]["idescuela"];
            $anioCic=$infoCiclo[0]["aniociclo"];
            $numCic=$infoCiclo[0]["numerociclo"];
        }

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

        return $this->render('AppBundle:Cursos:gestionarActividades.html.twig',array('infoCiclo'=>$infCiclo,'idCur'=>$idCurso,'idfac'=>$idfac,'idEsc'=>$idEsc,'anioCic'=>$anioCic,'numCic'=>$numCic,'actividadesList'=>$actividadesList));
    }

    public function findCursosAction(Request $request, $idfac=null, $idEsc=null, $anioCic=null, $numCic=null){
        $session = $request->getSession();
        if($session->has("id")){
            $menuList = array();
            $subMenuList = array();
            $menusList = $this->getDoctrine()->getEntityManager()->createQuery("SELECT m  
                FROM AppBundle:TblMenus m 
                ,AppBundle:TblPerfildetalle pd 
                ,AppBundle:TblPerfil p  
                ,AppBundle:TblUsuariosperfiles up  
                WHERE up.idusuario = :pIdUsuario
                AND pd.idmenu IS NOT NULL
                and pd.idmenu = m.idmenu
                and p.idperfil = pd.idperfil
                and up.idperfil = p.idperfil
                ORDER BY m.nombremenu ASC")->setParameters(array('pIdUsuario'=>$session->get('id')))->getResult();
            if($menusList){
                foreach ($menusList as $menuIter) {
                    $subMenu = $this->getDoctrine()->getEntityManager()->createQuery("SELECT sm
                        FROM AppBundle:TblMenus m 
                        ,AppBundle:TblMenusub sm
                        ,AppBundle:TblPerfildetalle pd
                        ,AppBundle:TblPerfil p
                        ,AppBundle:TblUsuariosperfiles up 
                        WHERE up.idusuario = :pIdUsuario
                        AND m.idmenu = :pIdMenu
                        AND pd.idsubmenu IS NOT NULL
                        and sm.idmenu = m.idmenu
                        and pd.idsubmenu = sm.idsubmenu
                        and p.idperfil = pd.idperfil
                        and up.idperfil = p.idperfil
                        ORDER BY sm.nombresubmenu ASC")->setParameters(array('pIdUsuario'=>$session->get('id'),'pIdMenu'=>$menuIter->getIdmenu()))->getResult();
                    if($subMenu){
                        foreach ($subMenu as $sm) {
                            array_push($subMenuList,$sm);
                        }
                    }
                    array_push($menuList,$menuIter);
                }

                $facultades = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblFacultades')->findAll();

                $escuelas = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblEscuelas')->findAll();

                //if($request->getMethod()=="POST"){
                    $idfacultad = "";    
                    if($idfac){
                        $idfacultad = $idfac;
                    }else{
                        $idfacultad = $request->get("facultadSelect"); 
                    }
                    $idEscuela = "";
                    if($idEsc){
                        $idEscuela = $idEsc;
                    }else{
                        $idEscuela = $request->get("escuelaSelect");
                    }
                    $anioCiclo = "";
                    if($anioCic){
                        $anioCiclo = $anioCic;
                    }else{
                        $anioCiclo = $request->get("anioCicloInput");
                    }
                    $numCiclo = "";
                    if($numCic){
                        $numCiclo = $numCic;
                    }else{
                        $numCiclo = $request->get("numCicloInput");
                    }
                    //return new Response($idfacultad);

                    $cursosList = $this->getDoctrine()->getEntityManager()->createQuery("SELECT c from AppBundle:TblCursos c
                        ,AppBundle:TblCiclos cic
                        ,AppBundle:TblMaterias m
                        ,AppBundle:TblEscuelas e
                        ,AppBundle:TblFacultades f
                        where f.idfacultad = :pIdFacultad
                        and e.idescuela = :pIdEscuela
                        and cic.aniociclo = :pAnioCiclo
                        and cic.numerociclo = :pNumCiclo
                        and cic.idciclo = c.idciclo
                        and m.idmateria = c.idmateria
                        and e.idescuela = m.idescuela
                        and f.idfacultad = e.idfacultad")->setParameters(array('pIdFacultad'=>$idfacultad,'pIdEscuela'=>$idEscuela,'pAnioCiclo'=>$anioCiclo,'pNumCiclo'=>$numCiclo))->getResult();

                        return $this->render('AppBundle:Cursos:cursos.html.twig', array('menuList'=>$menuList,'subMenuList'=>$subMenuList,'facultades'=>$facultades,'escuelas'=>$escuelas,'cursosList'=>$cursosList,'idfac'=>$idfac,'idEsc'=>$idEsc,'anioCic'=>$anioCic,'numCic'=>$numCic));   
                //}

                return $this->render('AppBundle:Cursos:cursos.html.twig', array('menuList'=>$menuList,'subMenuList'=>$subMenuList,'facultades'=>$facultades,'escuelas'=>$escuelas,'cursosList'=>null));
            }
        }else{
            $this->get("session")->getFlashBag()->add("mensaje","Debe estar logueado para ver este contenido."); 
               return $this->redirect($this->generateUrl("login"));
        }
        return $this->render('AppBundle:Cursos:cursos.html.twig'); 
    }

    public function indexAction(Request $request)
    {
    	$session = $request->getSession();
    	if($session->has("id")){
            $menuList = array();
            $subMenuList = array();
            $menusList = $this->getDoctrine()->getEntityManager()->createQuery("SELECT m  
                FROM AppBundle:TblMenus m 
                ,AppBundle:TblPerfildetalle pd 
                ,AppBundle:TblPerfil p  
                ,AppBundle:TblUsuariosperfiles up  
                WHERE up.idusuario = :pIdUsuario
                AND pd.idmenu IS NOT NULL
                and pd.idmenu = m.idmenu
                and p.idperfil = pd.idperfil
                and up.idperfil = p.idperfil
                ORDER BY m.nombremenu ASC")->setParameters(array('pIdUsuario'=>$session->get('id')))->getResult();
            if($menusList){
                foreach ($menusList as $menuIter) {
                    $subMenu = $this->getDoctrine()->getEntityManager()->createQuery("SELECT sm
                        FROM AppBundle:TblMenus m 
                        ,AppBundle:TblMenusub sm
                        ,AppBundle:TblPerfildetalle pd
                        ,AppBundle:TblPerfil p
                        ,AppBundle:TblUsuariosperfiles up 
                        WHERE up.idusuario = :pIdUsuario
                        AND m.idmenu = :pIdMenu
                        AND pd.idsubmenu IS NOT NULL
                        and sm.idmenu = m.idmenu
                        and pd.idsubmenu = sm.idsubmenu
                        and p.idperfil = pd.idperfil
                        and up.idperfil = p.idperfil
                        ORDER BY sm.nombresubmenu ASC")->setParameters(array('pIdUsuario'=>$session->get('id'),'pIdMenu'=>$menuIter->getIdmenu()))->getResult();
                    if($subMenu){
                        foreach ($subMenu as $sm) {
                            array_push($subMenuList,$sm);
                        }
                    }
                    array_push($menuList,$menuIter);
                }

                $facultades = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblFacultades')->findAll();

                $escuelas = $this->getDoctrine()->getManager()->getRepository('AppBundle:TblEscuelas')->findAll();

                return $this->render('AppBundle:Cursos:cursos.html.twig', array('menuList'=>$menuList,'subMenuList'=>$subMenuList,'facultades'=>$facultades,'escuelas'=>$escuelas,'cursosList'=>null,'idfac'=>null,'idEsc'=>null,'anioCic'=>null,'numCic'=>null));
            }
        }else{
    		$this->get("session")->getFlashBag()->add("mensaje","Debe estar logueado para ver este contenido."); 
               return $this->redirect($this->generateUrl("login"));
    	}
    	return $this->render('AppBundle:Cursos:cursos.html.twig');
    }

    public function salirAction(Request $request)
    {
        $session = $request->getSession();
        $session->clear();
        $this->get("session")->getFlashBag()->add("mensaje","Se ha cerrado sesión exitosamente.");
        return $this->render('AppBundle:Login:login.html.twig');
    }
}