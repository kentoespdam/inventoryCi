<?php

namespace App\Controllers\API;

use App\Models\Azizah\JenisBarangModel;
use App\Models\Schema\InfoSchemaModel;
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
        $lastUpdate = model(InfoSchemaModel::class)
        ->select('update_time')
        ->where([
            'table_schema' => getenv('database.azizah.database'),
            'table_name' => 'rekening'
            ])
            ->first();
            
        $isEqualUpdateTime=strtotime($lastUpdate->UPDATE_TIME) === strtotime($this->request->getGet('lastUpdate'));
        $cacheData=cache('jenis_barang');
        
        if ($isEqualUpdateTime && $cacheData) {
            return $this->respond(['data' => $cacheData, 'UPDATE_TIME' => $lastUpdate->UPDATE_TIME]);
        }
        //     return $this->respond(['data' => 'no data newer', 'UPDATE_TIME' => $lastUpdate->UPDATE_TIME]);

        $res = $this->model->where(['LEFT(kode,2)' => 15, 'inv <>' => 0])->find();
        cache()->save('jenis_barang', $res);
        return $this->respond(['data' => $res, 'UPDATE_TIME' => $lastUpdate->UPDATE_TIME]);
    }
}
