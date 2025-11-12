<?php

namespace App\Controllers\API;

use App\Models\Azizah\JenisBarangModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class JenisBarang extends ResourceController
{
    use ResponseTrait;
    protected $modelName = JenisBarangModel::class;
    protected $type = "json";
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $cacheData=cache('jenis_barang');

        if ($cacheData) {
            return $this->respond(['data' => $cacheData], 200);
        }

        $res = $this->model->where(['LEFT(kode,2)' => 15, 'inv <>' => 0])->find();
        cache()->save('jenis_barang', $res, 300);
        return $this->respond(['data' => $res], 200);
    }
}
