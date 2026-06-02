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
    protected $format    = 'json';

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @param string|null $unit
     * @param string|null $kode
     *
     * @return mixed
     */
    public function index($unit = null, $kode = null)
    {
        if ($unit === null || $kode === null) {
            return $this->respondNoContent('Hemm....');
        }

        $data = $this->model->lastStok($unit, $kode);

        // Filter items where current stock (jumlah) is less than minimum stock (Miny)
        $filtered = array_values(array_filter($data, static function ($item) {
            return (int) $item->jumlah < (int) $item->Miny;
        }));

        return $this->respond([
            'data'    => $filtered,
        ]);
    }

    /**
     * Return master inventory data by kode
     *
     * @param string|null $kode
     *
     * @return mixed
     */
    public function master($kode = null)
    {
        if ($kode === null) {
            return $this->respondNoContent('Hemm....');
        }

        $inventoryModel = model(AInventoryModel::class);
        $data = $inventoryModel
            ->where(['Kode' => $kode, 'Miny >' => 0])
            ->find();

        if (empty($data)) {
            return $this->respondNoContent('Inventory tidak ditemukan!');
        }

        // Sanitize Uraian by escaping double quotes
        foreach ($data as $item) {
            $item->Uraian = str_replace('"', '&quot;', $item->Uraian);
        }

        return $this->respond(['data' => $data]);
    }
}
