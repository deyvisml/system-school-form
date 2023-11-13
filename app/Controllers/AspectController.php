<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Aspect;

class AspectController extends BaseController
{
    public function index()
    {
        //
    }

    public function store()
    {
        $aspect_name = $this->request->getPost('aspect_name');
        $form_id = $this->request->getPost('form_id');

        $aspect_model = new Aspect;
        $aspect = $aspect_model->where("form_id", $form_id)->where("state_id", 1)->orderBy("order", "desc")->first();

        $order = $aspect ? $aspect->order + 1 : 1;

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

    public function delete()
    {
        $aspect_id = $this->request->getPost('aspect_id');

        $aspect_model = new Aspect;

        $record_was_deleted = $aspect_model->update($aspect_id, ["state_id" => 2]);

        $message="El aspecto se elimino exitosamente!";
        $error_occurred = false;
        
        if(!$record_was_deleted)
        {
            $message="Ocurrio un error en la eliminación del aspecto.";
            $error_occurred = true;
        }

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
        ));
    }

    public function update_order()
    {
        $aspect_ids = $this->request->getPost('aspect_ids');

        $aspect_model = new Aspect;

        foreach ($aspect_ids as $i => $aspect_id) {
            $aspect_model->update($aspect_id, ["order" => $i + 1]);
        }

        $message="Los aspectos fueron actualizados exitosamente!";
        $error_occurred = false;

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
        ));
    }
}
