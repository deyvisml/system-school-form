<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Alternative;

class AlternativeController extends BaseController
{
    public function index()
    {
        //
    }

    public function create()
    {
        $alternative = $this->request->getPost('alternative');
        $order = $this->request->getPost('order');
        $item_id = $this->request->getPost('item_id');

        $alternative_model = new Alternative;

        $data = [
            "alternative" => $alternative,
            "order" => $order,
            "item_id" => $item_id,
            "state_id" => 1,
        ];

        $record_was_inserted = $alternative_model->insert($data, false);

        $message = "La alternativa se creo exitosamente!";
        $error_occurred = false;

        if(!$record_was_inserted)
        {
            $message = "Ocurrio un error en la creación de la alternativa.";
            $error_occurred = true;
        }

        $alternative_id = $alternative_model->getInsertID();;

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
            "alternative_id" => $alternative_id,
        ));
    }

    public function delete()
    {
        $alternative_id = $this->request->getPost('alternative_id');
        $alternative_model = new Alternative;

        $record_was_deleted = $alternative_model->update($alternative_id, ["state_id" => 2]);

        $message = "La alternativa se elimino exitosamente!";
        $error_occurred = false;
        
        if(!$record_was_deleted)
        {
            $message = "Ocurrio un error en la eliminación de la alternativa.";
            $error_occurred = true;
        }

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
        ));
    }

    public function update_alternative_value()
    {
        $alternative_value = $this->request->getPost('alternative_value');
        $alternative_id = $this->request->getPost('alternative_id');
        $alternative_model = new Alternative;        

        $record_was_updated = $alternative_model->update($alternative_id, ["alternative" => $alternative_value]);

        $message = "La alternativa se actualizó exitosamente!";
        $error_occurred = false;
        
        if(!$record_was_updated)
        {
            $message = "Ocurrio un error en la actualización de la alternativa.";
            $error_occurred = true;
        }

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
        ));
    }
}
