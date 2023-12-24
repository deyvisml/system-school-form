<?php

namespace App\Models;

use CodeIgniter\Model;

class InstitucionForm extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'institucion_form';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "id",
        "institution_id",
        "form_id",
        "started",
        "sent",
        "started_at",
        "sent_at",
        "state_id",
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function get_instituciones_ids_by_form_id($form_id)
    {
        $instituciones_ids = $this->where("form_id", $form_id)->where("state_id", 1)->findColumn("institution_id");

        return $instituciones_ids;
    }

    public function get_forms_by_institucion_id($institucion_id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('institucion_form if');
        $builder->select('f.*, if.started, if.sent, if.started_at, if.sent_at, if.created_at as asigned_at');
        $builder->join('forms f', 'if.form_id = f.id');
        $builder->where("if.institution_id", $institucion_id);
        $builder->where("if.state_id", 1);
        $builder->where("f.state_id", 1);
        $builder->orderBy("if.created_at", "DESC");
        $query = $builder->get();

        return $query->getResult();
    }
}
