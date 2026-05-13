<table width="100%" border="0" style='font-size: 9pt; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;'>
    <tr>
        <td rowspan="6" width="140px" align="left">
            <img src="<?= $logo; ?>" style="width:120px;" />
        </td>
        <td colspan="2" style="font-weight: bold; font-size:16pt;">PERUMDA AIR MINUM TIRTA SATRIA</td>
    </tr>
    <tr>
        <td colspan="2">Jl. Prof. Dr. Suharso No. 53 PURWOKERTO 53114</td>
    </tr>
    <tr>
        <td width="100px">Telepon</td>
        <td>: 0281-632324</td>
    </tr>
    <tr>
        <td>Faximile</td>
        <td>: 0281-641654</td>
    </tr>
    <tr>
        <td>Email</td>
        <td>: <a href="pdam_banyumas@yahoo.com">pdam_banyumas@yahoo.com</a></td>
    </tr>
    <tr>
        <td>Website</td>
        <td>: <a href="www.perumdamts.com">www.perumdamts.com</a></td>
    </tr>
</table>
<hr>

<h2 style="display: block; text-align: center;">
    ORDER PERMINTAAN
</h2>

<span>Tanggal : <?php echo formatId($data->tgltrans); ?></span>
<?php
$no = 1;
$tgltrans = $data->tgltrans;
$rows = $data->detail;
$startIndex = 0;

foreach ($paginationDetail as $index => $itemsInPage) {
    if ($index > 0) {
        echo "<pagebreak/>";
    }
    $builder = tableBuilderDetailOrder($tgltrans, $rows, $no, $startIndex, $itemsInPage);
    echo $builder->table;
    $no = $builder->urut;
    $startIndex += $itemsInPage;
}
?>
<br />
<b>
    <i>
        Keterangan : <?php echo $data->keterangan; ?>
    </i>
</b>
<br />
<br />
<table class="ttd" width="100%">
    <tr>
        <td align="center" width="40%">Mengetahui/Menyetujui</td>
        <td align="center">Diperiksa Oleh,</td>
        <td align="center">Dibuat Oleh,</td>
    </tr>
    <tr>
        <td align="center">
            DIREKSI PERUMDA AIR MINUM TIRTA SATRIA <br>
            <?= $data->direksi_jabatan; ?>
        </td>
        <td align="center">Manajer Perlengkapan</td>
        <td align="center">Supervisor Persediaan</td>
    </tr>
    <tr>
        <td align="center" style="padding: 20px 0px 20px 0px;">
            ttd
        </td>
        <td align="center">
            ttd
        </td>
        <td align="center">
            ttd
        </td>
    </tr>
    <tr>
        <td align="center"><b><?php echo $data->direksi_nama; ?></b></td>
        <td align="center"><b><?php echo $data->manager_nama; ?></b></td>
        <td align="center"><b><?php echo $data->spv_nama; ?></b></td>
    </tr>
    <tr>
        <td align="center">&nbsp;</td>
        <td align="center"><b>NIPAM. <?php echo $data->manager; ?></b></td>
        <td align="center"><b>NIPAM. <?php echo $data->spv; ?></b></td>
    </tr>
</table>