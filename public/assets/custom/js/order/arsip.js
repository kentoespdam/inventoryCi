import { Api } from "../core/api.js"

let data = null

const Module = {
    init: () => {
        const nDate = new Date()
        let bln = nDate.getMonth() + 1
        bln = bln < 10 ? `0${bln}` : bln
        $('#tgl').val(`${bln}/${nDate.getFullYear()}`)
        $('#tgl').datepicker({
            format: "mm/yyyy",
            startView: 1,
            minViewMode: 1,
            autoclose: true
        })
        Module.action.cari()
    },
    action: {
        cari: async () => {
            const tgl = $('#tgl').val()
            const res = await Api.findById('Persediaan/Order/arsip', tgl)
            data = res ? res.data : null
            Module.setData.table()
        },
    },
    setData: {
        table: () => {
            if ($.fn.DataTable.isDataTable('#tbl')) $('#tbl').DataTable().destroy()
            setTimeout(() => {
                $('#tbl').DataTable({
                    scrollX: true,
                    processing: true,
                    data: data,
                    columns: [
                        {
                            title: "Action", data: 'id', render: (data, type, row) => {
                                const btLihat = `<button data-action='cetak' data-id='${data}' class='btn btn-xs btn-circle btn-success ico fa fa-eye'></button>`
                                return `${btLihat}`
                            }
                        },
                        { title: "Tanggal", data: 'tgltrans' },
                        { title: "Perihal", data: 'perihal' },
                        { title: "Supervisor", data: 'nmSpv' },
                        { title: "Direksi", data: 'nmDireksi' },
                        { title: "Dibuat Oleh", data: 'nmPengorder' },
                    ]
                })
            }, 500)
        }
    }
}

Module.init()
$('#cari').on('click', Module.action.cari)