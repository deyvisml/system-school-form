<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Form;
use App\Models\Aspect;
use App\Models\Item;
use App\Models\Alternative;
use App\Libraries\SuperComponente;
use App\Libraries\Componente;

class FormController extends BaseController
{
    public function index()
    {
        // get their own forms
        $session = \Config\Services::session();

        $form_model = new Form;

        $forms = $form_model->findAll();

        $data = array(
            "forms" => $aspects,
        );
    }

    public function index_own()
    {
        // get their own forms
        $session = \Config\Services::session();
        $user_id = $session->get("usua_ide");

        $form_model = new Form;

        $forms = $form_model->where("user_id", $user_id)->where("state_id", 1)->findAll();

        $data = array(
            "forms" => $forms,
        );

        return view("pages/MyForms", $data);
    }

    public function store()
    {
        $form_name = $this->request->getPost('form_name');
        $form_description = $this->request->getPost('form_description');

        $session = \Config\Services::session();
        $user_id = $session->get("usua_ide");

        $form_model = new Form;

        $data = [
            "name" => $form_name,
            "description" => $form_description,
            "user_id" => $user_id,
            "state_id" => 1,
        ];

        $record_was_inserted = $form_model->insert($data, false);

        $message="El formulario se creo exitosamente!";
        $error_occurred = false;
        
        if(!$record_was_inserted)
        {
            $message="Ocurrio un error en la creación del formulario.";
            $error_occurred = true;
        }

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
        ));
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

    public function config_items($form_id)
    {
        $aspect_model = new Aspect;
        $item_model = new Item;
        $alternative_model = new Alternative;

        // get aspects
        $aspects = $aspect_model->where("form_id", $form_id)->where("state_id", 1)->orderBy("order", "asc")->findAll();

        // get items of each aspect
        foreach($aspects as $aspect)
        {
            $aspect_id = $aspect->id;
            $items = $item_model->where("aspect_id", $aspect_id)->where("state_id", 1)->orderBy("order", "asc")->findAll();

            // get alternatives of each item
            foreach($items as $item)
            {
                if($item->item_type_id == 3 || $item->item_type_id == 4)
                {
                    $item_id = $item->id;
                    $alternatives = $alternative_model->where("item_id", $item_id)->where("state_id", 1)->orderBy("order", "asc")->findAll();
                    
                    $item->alternatives = $alternatives;
                }
            }

            $aspect->items = $items;
        }

        $data = array(
            "form_id" => $form_id,
            "aspects" => $aspects,
        );

        return view("pages/ConfigItems", $data);
    }

}
