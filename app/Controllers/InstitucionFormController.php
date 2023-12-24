<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InstitucionForm;

class InstitucionFormController extends BaseController
{
    public function index()
    {
        //
    }

    public function store()
    {
        $institucion_form_model = new InstitucionForm;

        $form_id = $this->request->getPost('form_id');
        $instituciones_ids = $this->request->getPost('instituciones_ids');

        $old_instituciones_ids = $institucion_form_model->get_instituciones_ids_by_form_id($form_id);

        $A = $instituciones_ids;
        $B = $old_instituciones_ids;

        if (!$instituciones_ids || count($instituciones_ids) == 0) $A = [];
        if (!$old_instituciones_ids || count($old_instituciones_ids) == 0) $B = [];

        // Obtener elementos únicos en cada arreglo
        $uniqueA = array_values(array_unique($A));
        $uniqueB = array_values(array_unique($B));

        $instituciones_ids_to_insert = array_diff($uniqueA, $uniqueB);
        $instituciones_ids_to_delete = array_diff($uniqueB, $uniqueA);

        // first -> "delete" instituciones (B - A)
        if (count($instituciones_ids_to_delete) > 0) {
            $data = [
                'state_id' => 2,
            ];

            $db = \Config\Database::connect();
            $builder = $db->table('institucion_form');
            $builder->whereIn("institution_id", $instituciones_ids_to_delete);
            $builder->where("form_id", $form_id);
            $builder->update($data);
            
            $records_updated = $builder->get()->getResult();
        }

        // second -> "insert" records (A - B)
        $records_were_inserted = true;
        if (count($instituciones_ids_to_insert) > 0) {
            $data = [];
            foreach ($instituciones_ids_to_insert as $institucion_id_to_insert) 
            {
                $data[] = [
                    "institution_id" => $institucion_id_to_insert,
                    "form_id" => $form_id
                ];
            }
            $records_were_inserted = $institucion_form_model->insertBatch($data);
        }

        $message = "Las asignación se realizó exitosamente!";
        $error_occurred = false;
        
        if(!$records_were_inserted)
        {
            $message = "Ocurrio un error en la asignación.";
            $error_occurred = true;
        }

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
        ));
    }
}
