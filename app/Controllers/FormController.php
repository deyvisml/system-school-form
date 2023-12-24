<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Form;
use App\Models\Nivel;
use App\Models\Institution;
use App\Models\InstitucionForm;
use App\Models\Aspect;
use App\Models\Item;
use App\Models\Alternative;
use App\Models\Answer;
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
        $form_model = new Form;
        $aspect_model = new Aspect;
        $item_model = new Item;
        $alternative_model = new Alternative;

        $form = $form_model->find($form_id);

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
            "form" => $form,
            "aspects" => $aspects,
        );

        return view("pages/ConfigItems", $data);
    }

    public function asign_institutions($form_id)
    {
        $nivel_model = new Nivel;
        $institution_model = new Institution;
        $institucion_form_model = new InstitucionForm;

        // get levels
        $niveles = $nivel_model->where('nive_esta_ide', 1)->orderBy("nive_orden", "ASC")->findAll();

        // get institutions by levels (also getting check institutions)
        foreach($niveles as $nivel)
        {
            $nivel->instituciones = $institution_model->get_institutions_by_nivel_id_and_form_id($nivel->nive_ide, $form_id);
        }

        $instituciones_ids_checked = $institucion_form_model->get_instituciones_ids_by_form_id($form_id);
        if (!$instituciones_ids_checked) { // if it's null
            $instituciones_ids_checked = array();
        }

        $data = array(
            "form_id" => $form_id,
            "niveles" => $niveles,
            "instituciones_ids_checked" => $instituciones_ids_checked,
        );

        return view("pages/form/AsignInstitution", $data);
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

    public function show_form($institucion_id, $form_id)
    {
        $form_model = new Form;
        $aspect_model = new Aspect;
        $item_model = new Item;
        $alternative_model = new Alternative;
        $institucion_form_model = new InstitucionForm;

        // Update form to started
        $institucion_form = $institucion_form_model->where('institution_id', $institucion_id)->where('form_id', $form_id)->where('state_id', 1)->first();
        if(!$institucion_form->started)
        {
            $data = [
                'started' => true,
                'started_at' => date('Y-m-d H:i:s'),
            ];
            $institucion_form_model->update($institucion_form->id, $data);
        }
        
        // Get form data
        $form = $form_model->find($form_id);

        // Get aspects of the form
        $aspects = $aspect_model->where("form_id", $form_id)->where("state_id", 1)->orderBy("order", "ASC")->findAll();

        // Get items for each aspect
        foreach ($aspects as $aspect) {
            $aspect->items = $item_model->where("aspect_id", $aspect->id)->where("state_id", 1)->orderBy("order", "ASC")->findAll();

            // Get alternatives for each item (type 3 and 4)
            foreach ($aspect->items as $item) {
                if ($item->item_type_id == 3 || $item->item_type_id == 4) {
                    $item->alternatives = $alternative_model->where("item_id", $item->id)->where("state_id", 1)->orderBy("order", "ASC")->findAll();
                }
            }
        }

        $data = array(
            "institucion_id" => $institucion_id,
            "form" => $form,
            "aspects" => $aspects,
        );

        return view("pages/FormCompletion", $data);
    }

    public function just_view_form($form_id)
    {
        $form_model = new Form;
        $aspect_model = new Aspect;
        $item_model = new Item;
        $alternative_model = new Alternative;
        
        // Get form data
        $form = $form_model->find($form_id);

        // Get aspects of the form
        $aspects = $aspect_model->where("form_id", $form_id)->where("state_id", 1)->orderBy("order", "ASC")->findAll();

        // Get items for each aspect
        foreach ($aspects as $aspect) {
            $aspect->items = $item_model->where("aspect_id", $aspect->id)->where("state_id", 1)->orderBy("order", "ASC")->findAll();

            // Get alternatives for each item (type 3 and 4)
            foreach ($aspect->items as $item) {
                if ($item->item_type_id == 3 || $item->item_type_id == 4) {
                    $item->alternatives = $alternative_model->where("item_id", $item->id)->where("state_id", 1)->orderBy("order", "ASC")->findAll();
                }
            }
        }

        $data = array(
            "form" => $form,
            "aspects" => $aspects,
        );

        return view("pages/JustViewForm", $data);
    }

    public function submit_form($institucion_id, $form_id)
    {
        $form_model = new Form;
        $aspect_model = new Aspect;
        $item_model = new Item;
        $alternative_model = new Alternative;
        $answer_model = new Answer;
        $institucion_form_model = new InstitucionForm;

        // FIRST -> CHECK IF ALL VALUES WERE SENT, AND ALSO STRUCT THEM ($data)

        // Get aspects of the form
        $aspects = $aspect_model->where("form_id", $form_id)->where("state_id", 1)->orderBy("order", "ASC")->findAll();

        $data = array();
        $i = 0;
        // Get items for each aspect
        foreach ($aspects as $aspect) {
            $aspect->items = $item_model->where("aspect_id", $aspect->id)->where("state_id", 1)->orderBy("order", "ASC")->findAll();
            
            // Get answer for each item
            foreach ($aspect->items as $item) {
                $is_mantadory_item = $item->mandatory;
                $error_occurred = false;
                $message = "Everything it's ok";
                
                $data[$i] = array();
                $data[$i]["item_id"] = $item->id;
                $data[$i]['item_type_id'] = $item->item_type_id;

                switch ($item->item_type_id) {
                    case '1':
                        $answer = $this->request->getPost('answer_question_'.$item->id);

                        if($is_mantadory_item)
                        {
                            if(empty($answer))
                            {
                                $message = "Existen preguntas obligatorias aun no respondidas.";
                                $error_occurred = true;
                            }
                        }
                        
                        $data[$i]['answer'] = $answer;
                        break;
                    case '2':
                        $answer = $this->request->getPost('answer_question_'.$item->id);

                        if($is_mantadory_item)
                        {
                            if(empty($answer))
                            {
                                $message = "Existen preguntas obligatorias aun no respondidas.";
                                $error_occurred = true;
                            }
                        }

                        $data[$i]['answer'] = $answer;
                        break;
                    case '3':
                        $alternative_id = $this->request->getPost('answer_question_'.$item->id);
                        $is_free_alternative = false;
                        $free_answer = null;

                        if($is_mantadory_item && empty($alternative_id))
                        {
                            $message = "Existen preguntas obligatorias aun no respondidas.";
                            $error_occurred = true;
                        }

                        if($alternative_id)
                        {
                            // check if the answer it's free to get the input value
                            $is_free_alternative = $alternative_model->find($alternative_id)->free;

                            if($is_free_alternative)
                            {
                                $free_answer = $this->request->getPost('free_answer_question_'.$item->id);
                                
                                if($is_mantadory_item && empty($free_answer))
                                {
                                    $message = "Existen preguntas obligatorias aun no respondidas.";
                                    $error_occurred = true;
                                }
                            }
                        }
                        
                        $data[$i]['alternative_id'] = $alternative_id;
                        $data[$i]['is_free_alternative'] = $is_free_alternative;
                        $data[$i]['free_answer'] = $free_answer;
                        break;
                    case '4':
                        $alternatives_ids = $this->request->getPost('answer_question_'.$item->id);
                        $exists_free_alternative = false;
                        $free_alternative_id = null;
                        $free_answer = null;

                        if($is_mantadory_item && empty($alternatives_ids))
                        {
                            $message = "Existen preguntas obligatorias aun no respondidas.";
                            $error_occurred = true;
                            break;
                        }

                        if($alternatives_ids)
                        {
                            foreach ($alternatives_ids as $alternative_id) {
                                $is_free_alternative = $alternative_model->find($alternative_id)->free;

                                if($is_free_alternative)
                                {
                                    $exists_free_alternative = true;
                                    $free_alternative_id = $alternative_id;

                                    $free_answer = $this->request->getPost('free_answer_question_'.$item->id);

                                    if($is_mantadory_item && empty($free_answer))
                                    {
                                        $message = "Existen preguntas obligatorias aun no respondidas.";
                                        $error_occurred = true;
                                    }
                                    break;
                                }
                            }
                        }
                        
                        $data[$i]['alternatives_ids'] = $alternatives_ids;
                        $data[$i]['exists_free_alternative'] = $exists_free_alternative;
                        $data[$i]['free_alternative_id'] = $free_alternative_id;
                        $data[$i]['free_answer'] = $free_answer;
                        break;
                    default:
                        $message = "Error, existen preguntas de tipo desconocido.";
                        $error_occurred = true;
                        break;
                }

                if($error_occurred)
                {
                    return json_encode(array(
                        "message" => $message,
                        "error_occurred" => $error_occurred,
                    ));
                }

                $i++;
            }
        }

        
        // SECOND -> SAVE ANSWERS ($data) IN DB

        $institucion_form_id = $institucion_form_model->where('institution_id', $institucion_id)->where('form_id', $form_id)->where('state_id', 1)->first()->id;

        foreach ($data as $element) {
            $prepare_data = array();
            $prepare_data['institucion_form_id'] = $institucion_form_id;
            $prepare_data['item_id'] = $element['item_id'];

            switch ($element['item_type_id']) {
                case '1':
                    $prepare_data["answer"] = $element['answer'];

                    // save
                    $answer_model->insert($prepare_data, false);
                    break;
                case '2':
                    $prepare_data["answer"] = $element['answer'];

                    // save
                    $answer_model->insert($prepare_data, false);
                    break;
                case '3':
                    if($element['alternative_id'])
                    {
                        $prepare_data["alternative_id"] = $element['alternative_id'];
                        if($element['is_free_alternative'])
                        {
                            $prepare_data["answer"] = $element['free_answer'];
                        }
                    }

                    // save
                    $answer_model->insert($prepare_data, false);
                    break;
                case '4':
                    if($element['alternatives_ids'])
                    {
                        foreach ($element['alternatives_ids'] as $alternative_id) {
                            $prepare_data_aux = $prepare_data;
                            $prepare_data_aux['alternative_id'] = $alternative_id;
    
                            if($element['exists_free_alternative'] && $element['free_alternative_id'] == $alternative_id)
                            {
                                $prepare_data_aux['answer'] = $element['free_answer'];
                            }
                            // save
                            $answer_model->insert($prepare_data_aux, false);
                        }
                    }
                    else
                    {
                        // save
                        $answer_model->insert($prepare_data, false);
                    }
                    break;
                
                default:
                    # code...
                    break;
            }
        }

        // THIRD -> UPDATE institucion_form TO sent
        $data = [
            'sent' => true,
            'sent_at' => date('Y-m-d H:i:s'),
        ];
        $institucion_form_model->update($institucion_form_id, $data);

        return json_encode(array(
            "message" => "El formulario fue enviado exitosamente!",
            "error_occurred" => false,
        ));
    }

    public function update_form_title_value()
    {
        $form_title = $this->request->getPost('form_title');
        $form_id = $this->request->getPost('form_id');
        $form_model = new Form;

        $record_was_updated = $form_model->update($form_id, ["form_title" => $form_title]);

        $message = "El título del formulario se actualizó exitosamente!";
        $error_occurred = false;
        
        if(!$record_was_updated)
        {
            $message = "Ocurrio un error en la actualización del título del formulario.";
            $error_occurred = true;
        }

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
        ));
    }

    public function update_form_description_value()
    {
        $form_description = $this->request->getPost('form_description');
        $form_id = $this->request->getPost('form_id');
        $form_model = new Form;

        $record_was_updated = $form_model->update($form_id, ["form_description" => $form_description]);

        $message = "La descripción del formulario se actualizó exitosamente!";
        $error_occurred = false;
        
        if(!$record_was_updated)
        {
            $message = "Ocurrio un error en la actualización de la descripción del formulario.";
            $error_occurred = true;
        }

        echo json_encode(array(
            "message" => $message,
            "error_occurred" => $error_occurred,
        ));
    }

}
