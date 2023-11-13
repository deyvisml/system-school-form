<?php
namespace App\Libraries;

class Componente{
    public $subComponentes;

    public function __construct(){
        $this->subComponentes = array();
    }
    public function agregar($componente){
        $this->subComponentes[]=$componente;
    }
    public function get($etiqueta,$clase,$propiedades){
        $componentes="";
        foreach($this->subComponentes as $reg){
            $componentes.=$reg;
        }
        return "
            <$etiqueta class='$clase' $propiedades>
                $componentes
            </$etiqueta>
        ";
    }

    public static function Tabla($id,$head,$data,$limit,$search,$paginacion,$clase,$botones,$js){
        $data=array(
            "id"=>$id,
            "head"=>$head,
            "clase"=>$clase,
            "data"=>$data,
            "botones"=>$botones,
            "limit"=>$limit,
            "search"=>$search,
            "paginacion"=>$paginacion,
            "js"=>$js
        );
        return view('componente/tabla',$data);
    }
    public static function Modal($id,$titulo,$body,$botonok,$size){
        $data=array(
            "id"=>$id,
            "titulo"=>$titulo,
            "body"=>$body,
            "botonok"=>$botonok,
            "size"=>$size
        );
        return view('componente/modal',$data);
    }
    public static function Boton($id,$tipo,$clase,$icono,$txt){
        return "
            <button 
                id='$id' 
                name='$id' 
                type='$tipo' 
                class='btn btn-sm btn-$clase'
            >
                <i class='$icono'></i>
                $txt
            </button>
        ";
    }
    public static function Input($id,$tipo,$value,$placeholder,$clase){
        return "
            <div class='form-floating mb-3'>
                <input 
                    type='$tipo' 
                    class='form-control form-control border-$clase'
                    id='$id'
                    name='$id'
                    placeholder='$placeholder'
                    value='$value'
                    autocomplete='off'
                    required='required'
                >
                <label for='$id' class='fs-5 text-$clase'>$placeholder</label>
            </div>
        ";
    }
    public static function Select($id,$label,$data,$clase,$itemVacio){
        $data2=array();
        foreach($data as $reg){
            $data2[]=(array)$reg;
        }
        $data=$data2;

        $opciones="";
        if($itemVacio==true){
            $opciones="<option value=''>Seleccione un item</option>";
        }
        foreach ($data as $reg) {
            $opciones.="<option value='".$reg['id']."'>".$reg['nombre']."</option>";
        }
        return "
            <div class='form-floating mb-3'>
                <select 
                    class='form-select border-$clase' 
                    id='$id' 
                    name='$id' 
                    required='required'
                >
                    $opciones
                </select>
                <label for='$id' class='fs-5 text-$clase'>$label</label>
            </div>
        ";
    }
    public static function Badge($clase,$txt){
        return "<span class=´badge bg-".$clase."´>$txt</span>";
    }
    public static function Row($componente){
        return "<div class='row'>$componente</div>";
    }
    public static function Col($col,$componente){
        return "<div class='$col'>$componente</div>";
    }
    public static function Rol($modulo,$nombre,$descripcion,$clase,$icono,$url){
        return "
            <div class='d-flex align-items-stretch border-$clase' style='border: 1px solid'>
                <div class='d-flex align-items-center justify-content-center flex-shrink-0 bg-$clase px-4 text-white'>
                        <i class='$icono fs-1'></i>
                </div>
                <div class='flex-grow-1 py-3 ms-3 border-$clase'>
                    <div class='h5 mb-0 text-$clase'>
                        <b>Módulo:</b>
                        $modulo
                    </div>
                    <div>
                    <a 
                        class='btn btn-xs btn-link mt-2 text-$clase'
                        onClick='cargarFuncion(\"$url\",\"$modulo\",\"$nombre\",\"$descripcion\")'
                    >Ir a $nombre</a>
                    </div>
                </div>
            </div>
        ";       
    }
    public static function Card1($titulo,$body,$clase){
        return "
            <div class='card bg-$clase'>
                <h5 class='card-header'>$titulo</h5>
                <div class='card-body'>
                    $body
                </div>
            </div>
        ";
    }

    public static function H1($body,$clase){
        return "
            <h1 class='$clase'>$body</h1>
        ";
    }
    public static function H2($body,$clase){
        return "
            <h2 class='$clase'>$body</h2>
        ";
    }
    public static function H3($body,$clase){
        return "
            <h3 class='$clase'>$body</h3>
        ";
    }
    public static function H4($body,$clase){
        return "
            <h4 class='$clase'>$body</h4>
        ";
    }
    public static function H5($body,$clase){
        return "
            <h5 class='$clase'>$body</h5>
        ";
    }
    public static function H6($body,$clase){
        return "
            <h6 class='$clase'>$body</h6>
        ";
    }
    public static function Div($body,$clase){
        return "
            <div class='$clase'>$body</div>
        ";
    }
    public static function Alert($body,$clase){
        return "
            <div class='alert alert-$clase'>$body</div>
        ";
    }
}