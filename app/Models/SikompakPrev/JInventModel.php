<?php

namespace App\Models\SikompakPrev;

use CodeIgniter\Model;

class JInventModel extends Model
{
    protected $DBGroup          = 'sikompakprev';
    protected $table            = 'j_invent';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

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

    public function findDetail($unit, $kode, $kdBarang, $bln_a)
    {
        $builder = $this->db->table($this->table)
            ->select(
                "MONTH(Tanggal) AS bulan,
                CONCAT(YEAR(Tanggal),IF(MONTH(Tanggal)<10,CONCAT('0',MONTH(Tanggal)),MONTH(Tanggal))) AS periode,
                SUM(Kurang) AS kurang"
            )
            ->where([
                "Unit" => $unit,
                "Kode" => $kode,
                "KdBarang" => $kdBarang,
                "MONTH(Tanggal)" => $bln_a
            ])
            // ->where("MONTH(Tanggal) BETWEEN $bln_a AND 12")
            ->groupBy('bulan')
            ->get()
            ->getResult();

        // echo $this->getLastQuery();
        return $builder;
    }
}
