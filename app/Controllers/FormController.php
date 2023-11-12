<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Form;
use App\Models\Aspect;
use App\Libraries\SuperComponente;
use App\Libraries\Componente;

class FormController extends BaseController
{
    public function index()
    {
        // get their own forms
        $session = \Config\Services::session();
        $user_id = $session->get("usua_ide");

        $form_model = new Form;

        $own_forms = $form_model->where("user_id", $user_id)->findAll();

        $container = new SuperComponente();

        foreach ($own_forms as $form) {

            $form_item = Componente::FormItem($form->id, $form->name, "form description", "Formularios", "Editar formulario", "rol descripton");
            
            $container->add($form_item);
        }

        // display the forms
        echo $container->get(
            $etiqueta="div",
            $clase="d-flex gap-3 flex-wrap",
            $propiedades=""
        );
    }

    public function config_aspects($form_id)
    {
        $aspect_model = new Aspect;
        $aspects = $aspect_model->where("form_id", $form_id)->where("state_id", 1)->orderBy("order", "asc")->findAll();

        $data = array(
            "aspects" => $aspects,
            "form_id" => $form_id,
        );

        return view("pages/ConfigAspects", $data);
    }

    public function create_aspect()
    {
        $aspect_name = $this->request->getPost('aspect_name');
        $form_id = $this->request->getPost('form_id');

        $aspect_model = new Aspect;
        $aspect = $aspect_model->where("form_id", $form_id)->where("state_id", 1)->orderBy("order", "desc")->first();

        $order = $aspect->order + 1;

        $data = [
            "name" => $aspect_name,
            "order" => $order,
            "form_id" => $form_id,
            "state_id" => 1,
        ];

        $record_was_inserted = $aspect_model->insert($data, false);

        $message="El aspecto se creo exitosamente!";
        $error_occurred = false;
        
        if(!$record_was_inserted)
        {
            $message="Ocurrio un error en la creación del aspecto.";
            $error_occurred = true;
        }

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
        ));
    }

}
