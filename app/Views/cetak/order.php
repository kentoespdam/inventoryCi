<htmlheader name="header1">
    <!-- Header -->
    <table width="100%" border="0" style='font-size: 11pt; font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;'>
        <tr>
            <td rowspan="6" width="160px" align="left">
                <img src="<?= $logo; ?>" style="width:130px;" />
            </td>
            <td colspan="2" style="font-weight: bold; font-size:20pt;">PERUMDA AIR MINUM TIRTA SATRIA</td>
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

    <hr class="garis-double" />
    <h3 style="padding:0; text-align:center; width:100%;">NOTA DINAS</h3>
    <!-- Kop Surat -->
    <table style="margin-left: 3em;">
        <tr>
            <td style="padding-right:2em;">Kepada</td>
            <td>: Direksi Perumda Air Minum Tirta Satria</td>
        </tr>
        <tr>
            <td>Lewat</td>
            <td>: <?= $data->lewat; ?></td>
        </tr>
        <tr>
            <td>Dari</td>
            <td>: Manajer Perlengkapan</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: <?php echo formatId($data->tgltrans); ?></td>
        </tr>
        <tr>
            <td>Nomor</td>
            <td>: <?= $data->nomor; ?></td>
        </tr>
        <tr>
            <td>Sifat</td>
            <td>: <?= $data->sifat; ?></td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>: <?= $page_count; ?> Lembar</td>
        </tr>
        <tr>
            <td>Hal</td>
            <td>: <?= $data->perihal; ?></td>
        </tr>
    </table>

    <hr class="garis-bawah">
</htmlheader>

<div class="container">
    <!-- Isi -->
    <div style="margin-left:3em">
        <p style="margin-bottom: 0px;">Bersama ini kami sampaikan order permintaan barang berupa :</p>
        <ul style="margin-left:-1em; margin-top:0px; margin-bottom:0px;">
            <?php
            foreach ($data->detail as $item) {
                array_map(function ($itm) {
                    $item = (object)$itm;
                    echo "<li>" . $item->uraian . "</li>";
                }, $item);
            }
            ?>
        </ul>
        <p style="margin-top: 0px;">untuk menambahkan saldo pada persediaan yang telah berkurang sesuai daftar terlampir.</p>
        <p style="text-align:justify;">Demikian untuk menjadi periksa, atas persetujuan dan realisasi permohonan ini kami sampaikan terima kasih.</p>
    </div>
    <!-- Ttd -->
    <table width="100%">
        <tr>
            <td rowspan="5" width="50%">&nbsp;</td>
            <td align="center"></td>
        </tr>
        <tr>
            <td align="center">Manajer Perlengkapan</td>
        </tr>
        <tr>
            <td align="center" style="padding-top:2em; padding-bottom: 2em;">Ttd</td>
        </tr>
        <tr>
            <td align="center"><?= $data->manager_nama; ?></td>
        </tr>
        <tr>
            <td align="center">NIPAM : <?= $data->manager; ?></td>
        </tr>
    </table>
</div>