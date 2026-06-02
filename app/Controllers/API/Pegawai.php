<?php

namespace App\Controllers\API;

use App\Models\Master\PegawaiModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Pegawai extends ResourceController
{
    use ResponseTrait;
    protected $modelName = PegawaiModel::class;
    protected $type = "json";

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return $this->respond(['data' => $this->model->getPegawaiInOrgId()]);
    }
}
