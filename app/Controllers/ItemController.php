<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Item;

class ItemController extends BaseController
{
    public function index()
    {
        //
    }

    public function delete()
    {
        $item_id = $this->request->getPost('item_id');

        $item_model = new Item;

        $record_was_deleted = $item_model->update($item_id, ["state_id" => 2]);

        $message="El item se elimino exitosamente!";
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
}
