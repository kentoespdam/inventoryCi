<?php

namespace App\Controllers\API;

use App\Models\Master\VPegawaiModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Pegawai extends ResourceController
{
    use ResponseTrait;
    protected $modelName = VPegawaiModel::class;
    protected $type = "json";

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index($posLevel = null)
    {
        if ($posLevel == null) return $this->respondNoContent("hemmm");
        if ($posLevel == "direksi") {
            $res = $this->model
                ->select("nipam, nama, org_code")
                ->where('pos_level', 2)
                ->orWhere('pos_level', 3)
                ->orderBy('nama', 'asc')
                ->find();
        }
        if ($posLevel == "manager") {
            $res = $this->model
                ->select("nipam, nama, org_code")
                ->where('pos_level', 4)
                ->orderBy('nama', 'asc')
                ->find();
        }
        if ($posLevel == "spv") {
            $res = $this->model
                ->select("nipam, nama, org_code")
                ->where('pos_level', 5)
                ->orderBy('nama', 'asc')
                ->find();
        }

        return $this->respond(['data' => $res]);
    }
}
