<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $DBGroup          = 'eoffice';
    protected $table            = 'employee';
    protected $returnType       = 'object';

    public function getPegawaiByNipam($id)
    {
        return $this->select('employee.emp_code, emp_profile.emp_name, position.pos_name')
            ->join('emp_profile', 'employee.emp_profile_id = emp_profile.emp_profile_id')
            ->join('position', 'employee.emp_pos_id = position.pos_id')
            ->where('employee.emp_code', $id)
            ->first();
    }

    public function getPegawaiInOrgId()
    {
        $org_ids = array_map(fn($item) => (int)$item, explode(',', env('org_ids')));
        return $this->select("employee.emp_code AS nipam, emp_profile.emp_name AS nama, position.pos_id AS pos_id, position.pos_name as jabatan, position.pos_level")
            ->join("emp_profile", "employee.emp_profile_id=emp_profile.emp_profile_id", "inner")
            ->join("position", "employee.emp_pos_id=position.pos_id", "inner")
            ->where("employee.emp_work_status", 6)
            ->whereIn("position.pos_org_id", $org_ids)
            ->findAll();
    }
}
