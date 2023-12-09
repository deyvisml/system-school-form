<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Form;
use App\Models\Aspect;
use App\Models\Item;
use App\Models\Alternative;
use App\Libraries\SuperComponente;
use App\Libraries\Componente;
use App\Libraries\Funciones;

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

        $forms = $form_model->where("user_id", $user_id)->where("state_id", 1)->orderBy("created_at", "desc")->findAll();

        foreach ($forms as $form) {
            $created_at = new \DateTime($form->created_at);

            $form->created_at = Funciones::get_fecha_formato($created_at->format('Y-m-d'));
        }

        $data = array(
            "forms" => $forms,
        );

        return view("pages/MyForms", $data);
    }

    public function get_data_by_id()
    {
        $form_id = $this->request->getPost('form_id');

        $form_model = new Form;

        $form = $form_model->where("id", $form_id)->where("state_id", 1)->first();

        $message = "La data se obtuvo exitosamente!";
        $error_occurred = false;
        
        if(!$form)
        {
            $message = "Ocurrio un error en la obtención de la data.";
            $error_occurred = true;
        }
        else
        {
            $created_at = new \DateTime($form->created_at);
            $form->created_at = Funciones::get_fecha_formato($created_at->format('Y-m-d'));
        }

        $data = array(
            "message" => $message,
            "error_occurred" => $error_occurred,
            "form" => $form,
        );
        
        echo json_encode($data);
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

    public function update()
    {
        $form_id = $this->request->getPost('form_id');
        $form_name = $this->request->getPost('form_name');
        $form_description = $this->request->getPost('form_description');
        $form_model = new Form;

        $record_was_updated = $form_model->update($form_id, ["name" => $form_name, "description" => $form_description]);

        $message = "El formulario se actualizó exitosamente!";
        $error_occurred = false;
        
        if(!$record_was_updated)
        {
            $message = "Ocurrio un error en la actualización del formulario.";
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

    public function delete()
    {
        $form_id = $this->request->getPost('form_id');
        $form_model = new Form;

        $record_was_deleted = $form_model->update($form_id, ["state_id" => 2]);

        $message = "El formulario se elimino exitosamente!";
        $error_occurred = false;
        
        if(!$record_was_deleted)
        {
            $message = "Ocurrio un error en la eliminación del formulario.";
            $error_occurred = true;
        }

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
        ));
    }

}
