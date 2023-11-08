<?php
namespace App\Libraries;

class SuperComponente{
    public $subComponentes;

    public function __construct(){
        $this->subComponentes = array();
    }
    public function add($componente){
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
}