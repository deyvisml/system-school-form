<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InstitucionForm;
use App\Libraries\Funciones;

class InstitucionController extends BaseController
{
    public function asign_forms()
    {
        $session = \Config\Services::session();
        $user_id = $session->get("usua_ide");
        $institucion_id = "1390"; // ! Get the institucion id thought user_id (each user belongs to an institution)

        $institucion_form_model = new InstitucionForm;

        $forms = $institucion_form_model->get_forms_by_institucion_id($institucion_id);

        foreach ($forms as $form) {
            $created_at = new \DateTime($form->created_at);
            $asigned_at = new \DateTime($form->asigned_at);

            $form->created_at = Funciones::get_fecha_formato($created_at->format('Y-m-d'));
            $form->asigned_at = Funciones::get_fecha_formato($asigned_at->format('Y-m-d'));
        }

        $data = array(
            "institucion_id" => $institucion_id,
            "forms" => $forms,
        );

        return view("pages/AsignedForms", $data);
    }
}
