import { Api } from "../core/api.js";
import { Kodes } from "../master/kodeOptions.js";
import { Units } from "../master/unitOption.js";

const frm = document.getElementById('frm')
let stok = null

const Module = {
    init: () => {
        Units.setOption()
        Kodes.setOptions()
        $('.select2').select2()
        Module.setData.table()
    },
    action: {
        cari: async () => {
            const unit = $('#unit').val()
            const kode = $('#kode').val()
            const res = await Api.showList(`Inventory/${unit}/${kode}`)
            stok = res.data
            Module.setData.table()
        }
    },
    setData: {
        table: () => {
            if ($.fn.DataTable.isDataTable('#tbl')) $('#tbl').DataTable().destroy();

            $('#tbl').DataTable({
                // processing: true,
                scrollX: true,
                details: false,
                data: stok,
                order: [[6, "asc"]],
                columns: [
                    { title: "Kode", data: "Kode" },
                    { title: "Kd Barang", data: "KdBarang" },
                    { title: "Nama Barang", data: "Uraian" },
                    { title: "Min Stok", data: "Miny" },
                    { title: "Tambah", data: "tambah" },
                    { title: "Kurang", data: "kurang" },
                    { title: "Jumlah", data: "jumlah" },
                    { title: "Rata2", data: "rata" },
                    { title: "Ukuran", data: "Ukuran" },
                    { title: "Satuan", data: "Satuan" },
                ]
            });
        }
    }
}

Module.init()

frm.addEventListener('submit', e => {
    Module.action.cari()
    e.preventDefault()
    return false
})