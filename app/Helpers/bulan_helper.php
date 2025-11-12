<?php

function getBulan($index)
{
    $listBulan = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];

    return $listBulan[$index];
}


function formatId($tgl)
{
    $ntgl = strtotime($tgl);
    $tahun = date('Y', $ntgl);
    $bulan = getBulan((int)date('m', $ntgl)-1);
    $tanggal = date('d', $ntgl);

    return $tanggal . " " . $bulan . " " . $tahun;
}
