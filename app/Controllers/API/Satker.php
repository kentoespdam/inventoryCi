<?php

namespace App\Controllers\API;

use App\Models\Azizah\SatkerModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Satker extends ResourceController
{
    use ResponseTrait;
    protected $modelName = SatkerModel::class;
    protected $type = "json";

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $cacheData=cache('satker');
        
        if($cacheData) {
            return $this->respond(['data' => $cacheData],200);
        }

        $res = $this->model->orderBy('Unit', 'ASC')->find();
        cache()->save('satker', $res);
        return $this->respond(['data' => $res], 200);
    }
}
