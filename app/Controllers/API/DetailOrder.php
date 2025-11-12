<?php

namespace App\Controllers\API;

use App\Models\SikompakNow\JInventModel as SikompakNowJInventModel;
use App\Models\SikompakPrev\JInventModel as SikompakPrevJInventModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class DetailOrder extends ResourceController
{
    use ResponseTrait;

    public function index($tgl = null, $unit = null, $kode = null, $kdBarang = null)
    {
        if (
            $tgl == null ||
            $unit == null ||
            $kode == null ||
            $kdBarang == null
        ) return $this->respondNoContent("hmm");

        $tahun = substr($tgl, 0, 4);
        $bln = substr($tgl, 5, 2);
        $minBln = $bln - 6;
        $resOld = [];
        $resNew = [];
        $res = (object)[];

        $invOld = new SikompakPrevJInventModel();
        if ($minBln < 0) {
            $a = 12 + $minBln;
            for ($i = $a; $i <= 12; $i++) {
                $b = ($i < 10) ? "0" . $i : $i;
                $f = $invOld->findDetail($unit, $kode, $kdBarang, $i);
                if (count($f) == 0) {
                    $f = [
                        (object)[
                            "bulan" => $i,
                            "periode" => ($tahun - 1) . $b,
                            "kurang" => 0
                        ]
                    ];
                }
                array_push($resOld, $f[0]);
            }
        } elseif ($minBln == 0) {
            $f = $invOld->findDetail($unit, $kode, $kdBarang, 12);
            if (count($f) == 0) {
                $f = [
                    (object)[
                        "bulan" => 12,
                        "periode" => ($tahun - 1) . "12",
                        "kurang" => 0
                    ]
                ];
            }
            array_push($resOld, $f[0]);
        }

        $invNew = new SikompakNowJInventModel();
        for ($j = $minBln; $j < $bln; $j++) {
            if ($j <= 0) continue;
            $c = ($j < 10) ? "0" . $j : $j;
            $f = $invNew->findDetail($unit, $kode, $kdBarang, $j);
            if (count($f) == 0) {
                $f = [
                    (object)[
                        "bulan" => $j,
                        "periode" => $tahun . $c,
                        "kurang" => 0
                    ]
                ];
            }
            array_push($resNew, $f[0]);
        }
        // $resNew = $invNew->findDetail($unit, $kode, $kdBarang, $bln);
        $lasStok = $invNew->lastStok($unit, $kode, $kdBarang);
        $m = $this->mergePakai($resOld, $resNew);
        $res->detail = $m;
        $res->stok = $lasStok;
        if (count($resOld) == 0 && count($resNew) == 0) return $this->respondNoContent("Data Tidak ditemukan");

        return $this->respond(["data" => $res]);
    }

    function mergePakai($a, $b)
    {
        $res = array_merge($a, $b);
        return $res;
    }
}
