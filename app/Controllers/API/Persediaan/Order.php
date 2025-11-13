<?php

namespace App\Controllers\API\Persediaan;

use App\Models\Persediaan\OrderModel;
use App\Models\Persediaan\PermintaanModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Order extends ResourceController
{
    use ResponseTrait;
    protected $modelName = OrderModel::class;
    protected $type = "json";
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        return $this->respond($this->model->findPage($this->request->getGet()));
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        if ($id == null) return $this->respondNoContent("Hemm...");
        $res = $this->model->find($id);
        if (!$res) return $this->respondNoContent("Tidak ada Order");
        $resDetail = model(PermintaanModel::class)
            ->select('*')
            ->join('v_jenisBarang', 't_permintaan.kode=v_jenisBarang.kode')
            ->where('t_permintaan.idOrder', $id)
            ->find();
        $res->detail = $resDetail;
        return $this->respond(['data' => $res]);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $body = json_decode($this->request->getBody());
        $simpan = $this->model->simpanOrder($body);
        if (!$simpan) return $this->respondNoContent("Gagal Menyimpan Data!!!!");
        $body->idOrder = $simpan;
        // $body->idOrder = 1;
        $simpanPermintaan = model(PermintaanModel::class)->simpanPermintaan($body);
        if (!$simpanPermintaan) return $this->respondNoContent("Gagal Menyimpan Data!!!!");
        return $this->respondCreated(["message" => "Order berhasil disimpan", "data" => $simpan]);
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        if (!$id) return $this->respondNoContent("Hemm...");
        $body = json_decode($this->request->getBody());
        $simpan = $this->model->update($id, $body);
        if (!$simpan) return $this->respondNoContent("Gagal Menyimpan Data!!!!");
        return $this->respondCreated(["message" => "Order berhasil diupdate", "data" => $simpan]);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        if (!$id) return $this->respondNoContent("Hemm...");
        $cek = $this->model->find($id);
        if ($cek->proses != 0) return $this->respondNoContent('Tidak dapat menghapus Data karena sudah diproses!!!');
        $hapus = $this->model->delete($id);
        if (!$hapus) return $this->respondNoContent("Gagal Menghapus Data!");
        model(PermintaanModel::class)->where('idOrder', $id)->delete();
        return $this->respondDeleted(['message' => "Order berhasil dihapus!!!", "data" => $hapus]);
    }

    public function arsip($bln, $thn)
    {
        $data = $this->model
            ->where([
                'proses' => 1,
                'YEAR(tgltrans)' => $thn,
                'MONTH(tgltrans)' => $bln,
            ])
            ->find();
        if (!$data) return $this->respondNoContent("Tidak ada Order");
        return $this->respond(['data' => $data]);
    }
}
