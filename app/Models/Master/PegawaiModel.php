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
            ->join('emp_profile','employee.emp_profile_id = emp_profile.emp_profile_id')
            ->join('position', 'employee.emp_pos_id = position.pos_id')
            ->where('employee.emp_code', $id)
            ->first();
    }
}
