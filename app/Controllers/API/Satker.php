<?php

namespace App\Controllers\API;

use App\Models\Azizah\SatkerModel;
use App\Models\Schema\InfoSchemaModel;
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
        $lastUpdate = model(InfoSchemaModel::class)
            ->select('update_time')
            ->where([
                'table_schema' => getenv('database.azizah.database'),
                'table_name' => 'satker'
            ])
            ->first();

        if (strtotime($lastUpdate->UPDATE_TIME) === strtotime($this->request->getGet('lastUpdate')))
            return $this->respond(['data' => 'no data newer', 'UPDATE_TIME' => $lastUpdate->UPDATE_TIME]);

        $res = $this->model->orderBy('Unit', 'ASC')->find();
        return $this->respond(['data' => $res, 'UPDATE_TIME' => $lastUpdate->UPDATE_TIME]);
    }
}
