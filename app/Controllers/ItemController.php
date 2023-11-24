<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Item;
use App\Models\Alternative;

class ItemController extends BaseController
{
    public function index()
    {
        //
    }

    public function create()
    {
        $aspect_id = $this->request->getPost('aspect_id');

        $item_model = new Item;

        $data = [
            "order" => 1,
            "mandatory" => 1,
            "item_type_id" => 1,
            "aspect_id" => $aspect_id,
        ];

        $record_was_inserted = $item_model->insert($data, false);

        $message = "El item se creo exitosamente!";
        $error_occurred = false;

        if(!$record_was_inserted)
        {
            $message = "Ocurrio un error en la creación del item.";
            $error_occurred = true;
        }

        $item_id = $item_model->getInsertID();;

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
            "item_id" => $item_id,
        ));
    }

    public function delete()
    {
        $item_id = $this->request->getPost('item_id');
        $item_model = new Item;

        $record_was_deleted = $item_model->update($item_id, ["state_id" => 2]);

        $message = "El item se elimino exitosamente!";
        $error_occurred = false;
        
        if(!$record_was_deleted)
        {
            $message = "Ocurrio un error en la eliminación del item.";
            $error_occurred = true;
        }

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
        ));
    }

    public function update_mandatory()
    {
        $item_id = $this->request->getPost('item_id');
        $mandatory = $this->request->getPost('mandatory');
        $item_model = new Item;        

        $record_was_updated = $item_model->update($item_id, ["mandatory" => $mandatory]);

        $message = "El item se actualizó exitosamente!";
        $error_occurred = false;
        
        if(!$record_was_updated)
        {
            $message = "Ocurrio un error en la actualización del item.";
            $error_occurred = true;
        }

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
        ));
    }

    public function update_item_type_id()
    {
        $item_id = $this->request->getPost('item_id');
        $item_type_id = $this->request->getPost('item_type_id');
        $item_model = new Item;        

        $record_was_updated = $item_model->update($item_id, ["item_type_id" => $item_type_id]);

        $message = "El item se actualizó exitosamente!";
        $error_occurred = false;
        
        if(!$record_was_updated)
        {
            $message = "Ocurrio un error en la actualización del item.";
            $error_occurred = true;
        }
        else
        {
            // "delete" their old alternatives
            $alternative_model = new Alternative;
            $alternative_model->where("item_id", $item_id)->set(["state_id" => 2])->update();
        }

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
        ));
    }

    public function update_item_value()
    {
        $item_value = $this->request->getPost('item_value');
        $item_id = $this->request->getPost('item_id');
        $item_model = new Item;        

        $record_was_updated = $item_model->update($item_id, ["question" => $item_value]);

        $message = "El item se actualizó exitosamente!";
        $error_occurred = false;
        
        if(!$record_was_updated)
        {
            $message = "Ocurrio un error en la actualización del item.";
            $error_occurred = true;
        }

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
        ));
    }

    public function update_items_order()
    {
        $items_ids = $this->request->getPost('items_ids');
        $item_model = new Item;

        $data = [];
        foreach ($items_ids as $index => $item_id) 
        {
            $data[] = [
                'id' => $item_id,
                'order' => $index + 1,
            ];
        }

        $records_were_updated = $item_model->updateBatch($data, 'id');

        $message = "Los items se actualizarón exitosamente!";
        $error_occurred = false;
        
        if(!$records_were_updated)
        {
            $message = "Ocurrio un error en la actualización de los items.";
            $error_occurred = true;
        }

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
        ));
    }
}
