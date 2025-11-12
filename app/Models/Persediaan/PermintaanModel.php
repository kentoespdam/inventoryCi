<?php

namespace App\Models\Persediaan;

use CodeIgniter\Model;

class PermintaanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 't_permintaan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'idOrder',
        'tgltrans',
        'unit',
        'kode',
        'kdBarang',
        'uraian',
        'ukuran',
        'satuan',
        'pemakaian',
        'stok',
        'permintaan',
        'proses',
        'created_at',
        'updated_at',
        'deleted_at'
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

    public function simpanPermintaan($body = null)
    {
        $req = array_reduce($body->permintaan, function ($r, $x) use ($body) {
            $o = (object)[];
            $stok=$x->stok[0];
            $o->idOrder = $body->idOrder;
            $o->tgltrans=$body->tgltrans;
            $o->unit=$body->unit;
            $o->kode=$stok->Kode;
            $o->kdBarang=$stok->KdBarang;
            $o->uraian=$stok->Uraian;
            $o->ukuran=$stok->Ukuran;
            $o->satuan=$stok->Satuan;
            $o->pemakaian=json_encode($x->detail);
            $o->stok=$stok->jumlah;
            $o->permintaan=$x->diminta;
            array_push($r, $o);
            return $r;
        }, []);

        $builder=$this->builder();

        $save = $builder->insertBatch($req);
        return $save;
    }
}
