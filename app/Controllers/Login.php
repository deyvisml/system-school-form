<?php 
namespace App\Controllers;
use App\Models\User;
use App\Libraries\Funciones;

class Login extends BaseController
{
    public function index()
    {
        $data=array(
            "system_name"=>"PLANTILLA DE SISTEMA",
            "error"=>$this->request->getVar('error'),
            "logo"=>"dota2.png"
        );
        return view('login/vlogin',$data);
    }
    public function verificar(){
        $where=array(
            "usua_user"=>$this->request->getPost('user'),
            "usua_pass"=>$this->request->getPost('pass'),
            "usua_esta_ide"=>1,
        );

        $objeto = new User();
        $usuarios = $objeto->where($where)->find();

        if(count($usuarios)==1){
            $fecha=Funciones::get_ahora_fecha();            

            $data_session=array(
                "login"=>md5("L0g¡NS!st3M4"),
                "usua_ide"=>$usuarios[0]->usua_ide,
                "enti_ide"=>$usuarios[0]->usua_enti_ide,
                "datos"=>$usuarios[0]->usua_nombres.", ".$usuarios[0]->usua_paterno." ".$usuarios[0]->usua_materno,
                "usuario"=>$usuarios[0]->usua_user,
                "siglas"=>"SIGLAS DEL SISTEMA",
                "icono"=>"fas fa-oil-can",
                "ini_fecha"=>Funciones::get_fecha_letras($fecha),
                "ini_hora"=>Funciones::get_ahora_hora()
            );
            $session = \Config\Services::session();
            $session->set($data_session);
            return redirect()->to(base_url('/application'));
        }
        else{
            return redirect()->to(base_url('/login?error=true'));
        }
        return 0;
    }
    public function ainscribir(){
        $where=array(
            "usua_user"=>"inscripciones",
            "usua_esta_ide"=>1,
        );
        $objeto = new User();
        $usuarios = $objeto->where($where)->find();
        if(count($usuarios)==1){
            $fecha=Funciones::get_ahora_fecha();
            $data_session=array(
                "login"=>md5("L0g¡NS!st3M4"),
                "usua_ide"=>$usuarios[0]->usua_ide,
                "enti_ide"=>$usuarios[0]->usua_enti_ide,
                "datos"=>$usuarios[0]->usua_nombres.", ".$usuarios[0]->usua_paterno." ".$usuarios[0]->usua_materno,
                "usuario"=>$usuarios[0]->usua_user,
                "siglas"=>"SIGLAS DEL SISTEMA",
                "icono"=>"fas fa-oil-can",
                "ini_fecha"=>Funciones::get_fecha_letras($fecha),
                "ini_hora"=>Funciones::get_ahora_hora()
            );
            $session = \Config\Services::session();
            $session->set($data_session);
            return redirect()->to(base_url('/application?go=true'));
        }
        else{
            return redirect()->to(base_url('/login?error=true'));
        }
        return 0;
    }
}
