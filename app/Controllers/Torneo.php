<?php 
namespace App\Controllers;
use App\Models\General;

use App\Libraries\Funciones;
use App\Libraries\Componente;
use App\Libraries\SuperComponente;

class Torneo extends BaseController
{
    public function inscribir(){
        $torneoEnCurso = General::getData(
            "torn_ide as id,torn_nombre as nombre,torn_jueg_ide as juego",
            "torneos",
            array(
                "torn_esta_ide"=>3
            ),
            "torn_ide"
        );
        if(count($torneoEnCurso)==0){
            echo Componente::Div("El próximo torneo se realizará en Enero");
            return;
        }
        $niveles = General::getData(
            "nive_ide as id,nive_nombre as nombre",
            "niveles",
            array(
                "nive_jueg_ide"=>$torneoEnCurso[0]->juego,
                "nive_esta_ide"=>1,
            ),
            "nive_peso"
        );
        $estrellas=array(
            array("id"=>"1","nombre"=>"1 Estrella"),
            array("id"=>"2","nombre"=>"2 Estrellas"),
            array("id"=>"3","nombre"=>"3 Estrellas"),
            array("id"=>"4","nombre"=>"4 Estrellas"),
            array("id"=>"5","nombre"=>"5 Estrellas"),
        );
        
        $formulario = new SuperComponente();
        $titulo=Componente::H4("Formulario de Inscripcion para Torneo","");
        $torneo=Componente::Select($id="torneo",$label="Torneo en Curso",$data=$torneoEnCurso,$clase="",false);
        $nick=Componente::Input($id="nick",$tipo="text",$value="",$placeholder="Apodo /Nick /ID /Usuario 4K",$clase);
        $nombres=Componente::Input($id="nombres",$tipo="text",$value="",$placeholder="Nombres",$clase);
        $apellidos=Componente::Input($id="apellidos",$tipo="text",$value="",$placeholder="Apellidos",$clase);
        $niveles=Componente::Select($id="nivel",$label="Nivel de juego",$data=$niveles,$clase,true);
        $estrellas=Componente::Select($id="estrellas",$label="Estrellas",$data=$estrellas,$clase,true);
        $email=Componente::Input($id="email",$tipo="email",$value="",$placeholder="Email",$clase);
        $celular=Componente::Input($id="celular",$tipo="number",$value="",$placeholder="WhatsApp","");
        $submit=Componente::Boton($id="inscribirse",$tipo="submit",$clase="primary",$icono="ti-save",$txt="Inscribirse");

        $formulario->add($titulo);
        $formulario->add($torneo);
        $formulario->add($nick);
        $formulario->add($nombres);
        $formulario->add($apellidos);
        $formulario->add($niveles);
        $formulario->add($estrellas);
        $formulario->add($email);
        $formulario->add($celular);
        $formulario->add($submit);

        echo "<script>
            $('#form_inscribirse').submit(function(e){
                e.preventDefault();
                openCargar();
                $.post('".base_url("/ins")."',$(this).serialize(),function(data){
                    data=JSON.parse(data);
                    alert(data.msg);
                    alert(data.clase);
                    alert(data.icono);
                    alertar(data.msg,data.clase,data.icono);
                    closeCargar();
                });
            });
        </script>";

        echo $formulario->get(
            $etiqueta="form",
            $clase="was-validated",
            $propiedades="id='form_inscribirse'"
        );
    }
    public function instorneo(){
        $data=array(
            "insc_torn_ide"=>$this->request->getPost("torneo"),
            "insc_nick"=>$this->request->getPost("nick"),
            "insc_nombres"=>$this->request->getPost("nombres"),
            "insc_apellidos"=>$this->request->getPost("apellidos"),
            "insc_nive_ide"=>$this->request->getPost("nivel"),
            "insc_estrellas"=>$this->request->getPost("estrellas"),
            "insc_email"=>$this->request->getPost("email"),
            "insc_celular"=>$this->request->getPost("celular"),
            "insc_freg"=>Funciones::get_ahora(),
        );
        $result=General::insertar("inscritos",$data);

        if($result==1){
            $torneo=General::getData("*","torneos",array("torn_ide"=>$data["insc_torn_ide"]),"torn_ide");
            $nivel=General::getData("*","niveles",array("nive_ide"=>$data["insc_nive_ide"]),"nive_ide");

            $asunto = "Torneos Peru 4k"; 
            $email = "victor.bejar.g@gmail.com,".$data["insc_email"];

            $pagina  = "<div><b>TORNEOS PERU 4K</b></div>";
            $pagina .= "<div>Usted acaba de inscribirse en el siguiente torneo:</div>";
            $pagina .= "<br>";
            $pagina .= "<div>".$torneo[0]->torn_nombre."</div>";
            $pagina .= "<div>Nombres y Apellidos".$data["insc_nombres"]." ".$data["insc_apellidos"]."</div>";
            $pagina .= "<div>Nivel".$nivel[0]->nive_nombre." ".$data["insc_estrellas"]."</div>";            
            $pagina .= "<br>";
            $pagina .= "<div>Si lee este mensaje es por que se inscribio correctamente .</div>";

            $send=1;
            //$send = Funciones::enviarEmail($asunto,$email,$pagina);

            $msg=Componente::Div("Se realizo correctamente su inscripción al torneo ".$torneo[0]->torn_nombre,"");
            $clase="alert alert-success";
            $icono="ti-check";
            if($send==1){
                $msg.=Componente::Div("Se envió un mensaje al correo electrónico: ".$data["insc_email"],"");
            }
        }
        else{
            $msg=Componente::Div("Ocurrio un error al tratar de inscribirte, intentalo nuevamente","");
            $clase="alert alert-success";
            $icono="ti-close";
        }
        
        echo json_encode(array(
            "msg"=>$msg,
            "clase"=>$clase,
            "icono"=>$icono,
        ));
    }
}
