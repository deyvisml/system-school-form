<?php

namespace App\Models;

use CodeIgniter\Model;

class Institution extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'instituciones';
    protected $primaryKey       = 'inst_ide';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'inst_ide',
        'inst_modular',
        'inst_clave',
        'inst_region',
        'inst_gestion2',
        'inst_provincia',
        'inst_distrito',
        'inst_gestion',
        'inst_gestion_ant',
        'inst_nive_ide',
        'inst_nombre',
        'inst_apellidos_dire',
        'inst_nombres_dire',
        'inst_dni_dire',
        'inst_cel1_dire',
        'inst_cel2_dire',
        'inst_email_dire',
        'inst_esta_ide',
        'inst_usua_asignado',
        'inst_fecha_reg',
        'inst_usua_asignado2',
    ];

    // Dates
    protected $useTimestamps = false;
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

    public function get_institutions_by_nivel_id($nivel_id)
    {
        $institutions = $this->where('inst_nive_ide', $nivel_id)->where('inst_esta_ide', 1)->findAll();

        return $institutions;
    }

    public function get_institutions_by_nivel_id_and_form_id($nivel_id, $form_id)
    {
        $db = \Config\Database::connect();

        $sql = "SELECT i.*, 
                    CASE 
                        WHEN i.inst_ide IN (
                            SELECT i.inst_ide
                            FROM institucion_form i_f
                            INNER JOIN instituciones i ON i_f.institution_id = i.inst_ide
                            INNER JOIN forms f ON i_f.form_id = f.id
                            WHERE i.inst_nive_ide = :nivel_id:
                            AND i_f.form_id = :form_id:
                            AND i.inst_esta_ide = 1
                            AND f.state_id = 1
                            AND i_f.state_id = 1
                        ) THEN 1
                        ELSE 0
                    END AS checked
                FROM instituciones i
                WHERE i.inst_nive_ide = :nivel_id:
                AND i.inst_esta_ide = 1";


        $query = $db->query($sql, ['nivel_id' => $nivel_id, 'form_id' => $form_id ]);

        $institutions = $query->getResult();

        return $institutions;
    }
}
