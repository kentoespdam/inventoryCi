<?php

namespace App\Controllers\API;

use App\Models\Azizah\AInventoryModel;
use App\Models\SikompakNow\JInventModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Inventory extends ResourceController
{
    use ResponseTrait;
    protected $modelName = JInventModel::class;
    protected $type = "json";
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */

    public function index($unit = null, $kode = null)
    {
        if ($unit == null || $kode == null) return $this->respondNoContent("Hemm....");
        $data = $this->model->lastStok($unit, $kode);
        $res = array_reduce($data, function ($r, $a) {
            if ((int)$a->jumlah < (int)$a->Miny) array_push($r, $a);
            return $r;
        }, []);
        return $this->respond(['data' => $res]);
    }

    public function master($kode = null)
    {
        if ($kode == null) return $this->respondNoContent("Hemm....");
        $data = model(AInventoryModel::class)
            ->where(['Kode' => $kode, 'Miny >' => 0])
            ->find();
        if (!$data) return $this->respondNoContent('Inventory tidak ditemukan!');
        $nData = array_reduce($data, function ($res, $item) {
            $item->Uraian = str_replace('"', '&quot;', $item->Uraian);
            array_push($res, $item);
            return $res;
        }, []);
        return $this->respond(['data' => $nData]);
    }
}
