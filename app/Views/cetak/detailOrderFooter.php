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