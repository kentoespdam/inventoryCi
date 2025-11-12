<?php

namespace App\Models\Persediaan;

use CodeIgniter\Model;
use App\Models\Master\PegawaiModel;

class OrderModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 't_order';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tgltrans',
        'perihal',
        'lewat',
        'nomor',
        'sifat',
        'spv',
        'spv_nama',
        'spv_jabatan',
        'manager',
        'manager_nama',
        'manager_jabatan',
        'direksi',
        'direksi_nama',
        'direksi_jabatan',
        'keterangan',
        'proses',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at'
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

    public function findPage(Array $request){
        $params=$this->requestHandler($request);
        $builder = $this->builder();
        $filteredCountBuilder = $this->db->table($this->table);
        if (count($params->queryData) > 0) {
            $builder = $builder->orLike($params->queryData);
            $filteredCountBuilder = $filteredCountBuilder->orLike($params->queryData);
        }
        if(isset($params->order)){
            $builder = $builder->orderBy($params->order->column, $params->order->dir);
        }
        $data = $builder->limit($params->limit, $params->offset)->get()->getResult();
        $filteredCount=$filteredCountBuilder->countAllResults();
        $recordTotal = $this->countAllResults();
        return [
            'draw' => $params->draw, 
            'recordsTotal' => $recordTotal, 
            'recordsFiltered' => $filteredCount ?? $recordTotal, 
            'data' => $data
        ];
        // return $params;
    }

    private function requestHandler(Array $request){
        $draw = $request['draw'];
        $limit = $request['length'];
        $offset = $request['start'];
        $query = $request['search']['value'];
        $orderColumn = $request['order'][0];
        $columns=$request['columns'];

        $queryData=[];
        if($query!=""){
            for($i=0; $i<count($columns); $i++){
                if($columns[$i]['searchable']=="true"){
                    $queryData[$columns[$i]['data']]=$query;
                };
            };
        };

        
        return (object) [
            "draw" => $draw,
            "limit" => $limit,
            "offset" => $offset,
            "queryData" => $queryData,
            "order"=> (object)[
                "column" => $columns[$orderColumn['column']]['data'],
                "dir"=>$orderColumn['dir']
            ],
            "columns"=>$request['columns']
        ];
    }

    public function simpanOrder($body)
    {   
        $pegawaiModel=model(PegawaiModel::class);
        $created_by=$pegawaiModel->getPegawaiByNipam($body->created_by);
        $manager=$pegawaiModel->getPegawaiByNipam($body->manager);
        $spv=$pegawaiModel->getPegawaiByNipam($body->spv);
        $direksi=$pegawaiModel->getPegawaiByNipam($body->direksi);
        $data=[
            'tgltrans'=>$body->tgltrans,
            'perihal'=>$body->perihal,
            'lewat'=>$body->lewat,
            'nomor'=>$body->nomor,
            'sifat'=>$body->sifat,
            'spv'=>$spv->emp_code,
            'spv_nama'=>$spv->emp_name,
            'spv_jabatan'=>$spv->pos_name,
            'manager'=>$manager->emp_code,
            'manager_nama'=>$manager->emp_name,
            'manager_jabatan'=>$manager->pos_name,
            'direksi'=>$direksi->emp_code,
            'direksi_nama'=>$direksi->emp_name,
            'direksi_jabatan'=>$direksi->pos_name,
            'keterangan'=>$body->keterangan,
            'proses'=>0,
            'created_by'=>$created_by->emp_code,
            'created_by_name'=>$created_by->emp_name,
        ];

        $builder=$this->builder();
        $builder->insert($data);
        return $this->db->insertID();
    }
}
