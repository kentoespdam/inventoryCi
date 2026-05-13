<?php

function calculateDetailOrderPagination(int $totalItems): array
{
    if ($totalItems <= 5) {
        return [$totalItems];
    } elseif ($totalItems >= 6 && $totalItems <= 10) {
        return [$totalItems - 1, 1];
    } else {
        $pages = [];
        $remaining = $totalItems;
        while ($remaining > 10) {
            $pages[] = 10;
            $remaining -= 10;
        }
        $pages[] = $remaining;
        return $pages;
    }
}

function calculateOrderPagination(int $totalItems): array
{
    if ($totalItems <= 8) {
        return [$totalItems];
    } elseif ($totalItems == 9) {
        return [8, 1];
    } elseif ($totalItems == 10) {
        return [9, 1];
    } elseif ($totalItems == 11) {
        return [10, 1];
    } else {
        $pages = [];
        $remaining = $totalItems;
        while ($remaining > 11) {
            $pages[] = 11;
            $remaining -= 11;
        }
        $pages[] = $remaining;
        return $pages;
    }
}

function tableBuilderDetailOrder(string $tgltrans, array $data, int $urut, int $startIndex, int $count = 8)
{
    $tglExpl = explode('-', $tgltrans);
    $bulan = $tglExpl[1];
    $minBln = $bulan - 6;
    $startRow = $startIndex;
    $endRow = count($data) >= $startRow + $count ? $startRow + $count : count($data);


    $str = '<table class="detailOrder" border="1" style="border-collapse: collapse;" width="100%">';
    $str .= '<thead>';
    $str .= '<tr>';
    $str .= '<th rowspan="2">NO</th>';
    $str .= '<th rowspan="2">Nama Barang</th>';
    $str .= '<th rowspan="2">Satuan</th>';
    $str .= '<th colspan="6">Realisasi Penggunaan 6 Bulan terakhir</th>';
    $str .= '<th rowspan="2">Jumlah</th>';
    $str .= '<th rowspan="2">Rata2 per bulan</th>';
    $str .= '<th rowspan="2">Stok</th>';
    $str .= '<th rowspan="2">Permintaan</th>';
    $str .= '</tr>';
    $str .= '<tr>';
    if ($minBln < 0) {
        $a = 12 + $minBln;
        for ($i = $a; $i <= 12; $i++) {
            $str .= "<th>" . getBulan($i - 1) . "</th>";
        }
    } elseif ($minBln == 0) {
        $str .= "<th>Desember</th>";
    }
    for ($j = $minBln - 1; $j < (int)$bulan - 1; $j++) {
        if ($j >= 0)
            $str .= "<th>" . getBulan($j) . "</th>";
    }
    $str .= '</tr>';
    $str .= '</thead>';
    $str .= '<tbody>';

    for ($i = $startRow; $i < $endRow; $i++) {
        $item = (object)$data[$i];
        $pemakaian = json_decode($item->pemakaian);
        // print_r($pemakaian);
        $str .= "<tr>";
        $str .= "<td>" . $urut . "</td>";
        $str .= "<td nowrap='nowrap'>" . $item->uraian . "</td>";
        // $str .= "<td>" . $item->ukuran . "</td>";
        $str .= "<td>" . $item->satuan . "</td>";
        $str .= array_reduce($pemakaian, function ($str1, $itm) {
            $str1 .= "<td align='right'>" . number_format($itm->kurang, 2, ",", ".") . "</td>";
            return $str1;
        }, "");
        $jml = array_reduce($pemakaian, function ($r, $i) {
            $r += $i->kurang;
            return $r;
        }, 0);
        $str .= "<td align='right'>" . number_format($jml, 2, ",", ".") . "</td>";
        $str .= "<td align='right'>" . number_format((float)($jml / 6), 2, ',', '.') . "</td>";
        $str .= "<td align='right'>" . number_format($item->stok, 2, ",", ".") . "</td>";
        $str .= "<td align='right'>" . number_format($item->permintaan, 2, ",", ".") . "</td>";
        $str .= "</tr>";
        $urut++;
    }

    $str .= "</tbody>";
    $str .= "</table>";

    return (object)[
        "table" => $str,
        "urut" => $urut
    ];
}

function tableBuilderOrder(array $data, int $urut, int $startIndex, int $count = 11)
{
    $startRow = $startIndex;
    $endRow = count($data) >= $startRow + $count ? $startRow + $count : count($data);

    $str = '<table class="detailOrder" border="1" style="border-collapse: collapse;" width="100%">';
    $str .= '<thead>';
    $str .= '<tr>';
    $str .= '<th>No</th>';
    $str .= '<th>Nama Barang</th>';
    $str .= '<th>Satuan</th>';
    $str .= '<th>Rata2 per Bulan</th>';
    $str .= '<th>Stok</th>';
    $str .= '<th>Permintaan</th>';
    $str .= '</tr>';
    $str .= '</thead>';
    $str .= '<tbody>';

    for ($i = $startRow; $i < $endRow; $i++) {
        $item = (object)$data[$i];
        $pemakaian = json_decode($item->pemakaian);
        $jml = array_reduce($pemakaian, function ($r, $itm) {
            $r += $itm->kurang;
            return $r;
        }, 0);
        $str .= "<tr>";
        $str .= "<td>" . $urut . "</td>";
        $str .= "<td nowrap='nowrap'>" . $item->uraian . "</td>";
        $str .= "<td>" . $item->satuan . "</td>";
        $str .= "<td align='right'>" . number_format((float)($jml / 6), 2, ',', '.') . "</td>";
        $str .= "<td align='right'>" . number_format($item->stok, 2, ",", ".") . "</td>";
        $str .= "<td align='right'>" . number_format($item->permintaan, 2, ",", ".") . "</td>";
        $str .= "</tr>";
        $urut++;
    }

    $str .= "</tbody>";
    $str .= "</table>";

    return (object)[
        "table" => $str,
        "urut" => $urut
    ];
}
