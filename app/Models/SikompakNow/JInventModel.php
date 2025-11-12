<?php

namespace App\Models\SikompakNow;

use CodeIgniter\Model;

class JInventModel extends Model
{
    protected $DBGroup          = 'sikompaknow';
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

    public function lastStok($unit = null, $kode = null, $kdBarang = null)
    {
        $builder = $this->db->table($this->table)
            ->select(
                "j_invent.Unit, 
                j_invent.Kode, 
                j_invent.KdBarang, 
                v_inventory.Uraian, 
                v_inventory.Ukuran, 
                v_inventory.Satuan, 
                v_inventory.Miny, 
                SUM(j_invent.Tambah) as tambah, 
                SUM(j_invent.Kurang) as kurang,
                round(AVG(j_invent.Kurang),2) as rata,
                SUM(tambah - kurang) as jumlah"
            )
            ->join("v_inventory", "j_invent.Kode = v_inventory.Kode AND j_invent.KdBarang = v_inventory.KdBarang", 'right');
        $builder->notLike('v_inventory.Uraian', 'Bekas');
        if ($unit != "0000") $builder->where(["j_invent.unit" => $unit]);
        if ($kode != "All") $builder->where("j_invent.Kode", $kode);
        if ($kdBarang != null) $builder->where('j_invent.KdBarang', $kdBarang);
        $builder->groupBy("j_invent.Unit, j_invent.Kode, j_invent.KdBarang");
        $res = $builder->get()->getResult();
        if (count($res) == 0) return $this->notFoundInventory($unit, $kode, $kdBarang);
        return $res;
    }

    private function notFoundInventory($unit = null, $kode = null, $kdBarang = null)
    {
        $builder = $this->db->table('v_inventory')
            ->select(
                "$unit as Unit, 
                Kode, 
                KdBarang, 
                Uraian, 
                Ukuran, 
                Satuan, 
                Miny, 
                0 as tambah, 
                0 as kurang,
                0 as rata,
                0 as jumlah"
            );
        $builder->where("Kode", $kode);
        $builder->where('KdBarang', $kdBarang);
        $res = $builder->get()->getResult();
        return $res;
    }

    public function findDetail($unit, $kode, $kdBarang, $bln)
    {
        $builder = $this->builder()
            ->select(
                "MONTH(Tanggal) AS bulan,
                CONCAT(YEAR(Tanggal),IF(MONTH(Tanggal)<10,CONCAT('0',MONTH(Tanggal)),MONTH(Tanggal))) AS periode,
                SUM(Kurang) AS kurang"
            )
            ->where([
                "Unit" => $unit,
                "Kode" => $kode,
                "KdBarang" => $kdBarang,
                "MONTH(Tanggal)" => $bln
            ])
            ->groupBy('bulan')
            ->get()
            ->getResult();

        // echo $this->getLastQuery();
        return $builder;
    }
}
