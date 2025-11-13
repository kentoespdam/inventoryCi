<?php

namespace App\Controllers\Cetak;

use App\Controllers\BaseController;
use App\Models\Persediaan\OrderModel;
use App\Models\Persediaan\PermintaanModel;
use CodeIgniter\API\ResponseTrait;
use Mpdf\HTMLParserMode;
use Mpdf\Mpdf;

class Order extends BaseController
{
    use ResponseTrait;

    function __construct()
    {
        helper('bulan');
    }

    public function index($orderId = null)
    {
        if ($orderId == null) return $this->respondNoContent("Hemmm");

        $res = model(OrderModel::class)->find($orderId);
        if (!$res) return $this->respondNoContent("Tidak ada Order");
        
        $resDetail = model(PermintaanModel::class)
            ->join('v_jenisBarang', 't_permintaan.kode=v_jenisBarang.kode')
            ->where('t_permintaan.idOrder', $orderId)
            ->find();
        // split resDetail's with max 6 items
        $resDetail = array_chunk($resDetail, 6);
        $res->detail = $resDetail;

        return $this->buildPdf($res);
        // return;
    }

    function buildPdf($data)
    {
        $body = [
            "data" => $data
        ];
        $style = file_get_contents(APPPATH . '../public/assets/custom/css/cetak/order.css');
        $logo = file_get_contents(APPPATH . '../public/assets/images/logopdam.png');
        $body['logo'] = 'data:image/PNG;base64,' . base64_encode($logo);
        $body['page_count'] = round(count($data->detail) / 6) == 0 ? 1 : round(count($data->detail) / 6);

        $html = view('cetak/order', (array)$body);
        // $html2 = view('cetak/detailOrder', (array)$body);
        $orderHeader= view('cetak/detailOrderKop', (array)$body);
        $orderTable= view('cetak/detailOrderTable', (array)$body);
        $orderFooter= view('cetak/detailOrderFooter', (array)$body);

        // return $html.$orderHeader.$orderTable.$orderFooter;

        $pdfConfig = ['mode' => 'utf-8', 'format' => 'A4'];
        try {
            $this->response->setHeader('Content-Type', 'application/pdf');
            $pdf = new Mpdf($pdfConfig);
            $pdf->debug = true;
            $pdf->SetFooter('Page {PAGENO} of {nb}');
            $pdf->AddPage('P', '', '', '', '', 10, 10, 10, 10);
            $pdf->WriteHTML($style, HTMLParserMode::HEADER_CSS);
            $pdf->WriteHTML($html, HTMLParserMode::HTML_BODY);
            $pdf->AddPage('L', '', '', '', '', 10, 10, 10, 10);
            $pdf->WriteHTML($style, HTMLParserMode::HEADER_CSS);
            $pdf->WriteHTML($orderHeader, HTMLParserMode::HTML_BODY);
            $pdf->WriteHTML($orderTable, HTMLParserMode::HTML_BODY);
            $pdf->WriteHTML($orderFooter, HTMLParserMode::HTML_BODY);
            $pdf->Output();
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
        return;
    }
}
