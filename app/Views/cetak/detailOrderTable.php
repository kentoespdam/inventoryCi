<?php
$detailCount = count($data->detail);
$counter=0;
$no = 1;
foreach ($data->detail as $chunk): ?>
    <table class="detailOrder" border="1" style="border-collapse: collapse;">
        <thead>
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">Nama Barang</th>
                <!-- <th rowspan="2">Ukuran</th> -->
                <th rowspan="2">Satuan</th>
                <th colspan="6">Realisasi Penggunaan 6 Bulan terakhir</th>
                <th rowspan="2">Jumlah</th>
                <th rowspan="2">Rata2 per bulan</th>
                <th rowspan="2">Stok</th>
                <th rowspan="2">Permintaan</th>
            </tr>
            <tr>
                <?php
                helper('bulan');
                $tglExpl = explode('-', $data->tgltrans);
                $bulan = $tglExpl[1];
                $minBln = $bulan - 6;
                $str = "";
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
                echo $str;
                ?>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($chunk as $itm) {
                $item = (object)$itm;
                $pemakaian = json_decode($item->pemakaian);
                // print_r($pemakaian);
                $str = "<tr>";
                $str .= "<td>" . $no . "</td>";
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
                echo $str;
                $no++;
            };
            ?>
        </tbody>
    </table>
    <?php 
    if ($detailCount > 1 && $counter < $detailCount - 1) : ?>
        <pagebreak />
    <?php
    endif;
    $counter++;
    ?>
<?php endforeach; ?>