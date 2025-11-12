import { Api } from "../core/api.js"
import { DateHelper } from "../core/dateHelper.js"
import { MainApp } from "../core/main.js"
import { Direksi } from "../master/direksiOptions.js"
import { Mgr } from "../master/managerOptions.js"
import { Spv } from "../master/spvOptions.js"
import { Units } from "../master/unitOption.js"
import { Orders } from "./script.js"

let detailData = []
const ttgltrans = document.getElementById('tgltrans')
const tperihal = document.getElementById('perihal')
const tnomor = document.getElementById('nomor')
const tlewat = document.getElementById('lewat')
const tsifat = document.getElementById('sifat')
const tspv = document.getElementById('spv')
const tmanager = document.getElementById('manager')
const tdireksi = document.getElementById('direksi')
const tunit = document.getElementById('unit')
const tKeterangan = document.getElementById('keterangan')

const Module = {
    init: () => {
        if (Module.setData.getLocalStorageData()?.length > 0)
            localStorage.removeItem("detailData")
        $('#tgltrans').val(DateHelper.generateYmd())
        Units.setOption()
        Spv.setOptions()
        Mgr.setOptions()
        Direksi.setOptions()
        setTimeout(() => { $('.select2').select2() }, 1000)
        Module.setData.headerBulan()
        Module.setData.table()
        $('#created_by').val($('#sesNipam').val())
    },
    action: {
        simpan: async () => {
            const frmData = {
                created_by: created_by.value,
                tgltrans: ttgltrans.value,
                perihal: tperihal.value,
                nomor: tnomor.value,
                lewat: tlewat.value,
                sifat: tsifat.value,
                unit: tunit.value,
                spv: tspv.value,
                manager: tmanager.value,
                direksi: tdireksi.value,
                permintaan: Module.setData.getLocalStorageData(),
                keterangan: tKeterangan.value
            }

            const res = await Api.post('Persediaan/Order', frmData)
            if (!res) return
            toastr['success'](res.message)
            // detailData = []
            Module.action.reset()
            return false
        },
        reset: () => {
            let direksi = $('#direksi').val()
            $('#frm')[0].reset()
            detailData = []
            MainApp.viewForm.show('box-table')
            MainApp.viewForm.hide('box-form')
            $('#tgltrans').val(DateHelper.generateYmd())
            $('#created_by').val($('#sesNipam').val())
            $('#direksi').val(direksi).trigger('change')
            Orders.init()
        }
    }, 
    setData: {
        addDetail: (data) => {
            data.stok[0].Uraian = MainApp.escapeHtml(data.stok[0].Uraian)
            Module.setData.setLocalStorageData(data)
            Module.setData.table()
        },
        getLocalStorageData: () => {
            return JSON.parse(localStorage.getItem("detailData"))
        },
        setLocalStorageData: (data) => {
            if (Module.setData.getLocalStorageData() == null) localStorage.setItem("detailData", `[${JSON.stringify(data)}]`)
            else {
                let tmp = Module.setData.getLocalStorageData()
                tmp.push(data)
                localStorage.setItem("detailData", JSON.stringify(tmp))
            }
        },
        spliceLocalStorageData: (idx) => {
            let tmp = Module.setData.getLocalStorageData()
            tmp = tmp.filter((item, index) => index != idx)
            localStorage.setItem("detailData", JSON.stringify(tmp))
        },
        removeDetail: (data) => {
            // detailData.splice(data, 1)
            Module.setData.spliceLocalStorageData(data)
            Module.setData.table()
        },
        headerBulan: () => {
            const tgltrans = ttgltrans.value
            const tt = tgltrans.split('-')
            const th = tt[0]
            const bl = tt[1]
            const minBl = parseInt(bl) - 6
            let str = ``
            if (minBl < 0) {
                let a = 12 + minBl
                for (let i = a; i <= 12; i++) {
                    str += `<th>${DateHelper.getBulan(i - 1)}</th>`
                }
            }
            else if (minBl == 0) {
                str += `<th>Desember</th>`
            }
            for (let j = minBl - 1; j < parseInt(bl) - 1; j++) {
                // console.log(DateHelper.getBulan(j))
                if (j >= 0)
                    str += `<th>${DateHelper.getBulan(j)}</th>`
            }

            $('#trBulan').html(str)
        },
        table: () => {
            if ($.fn.DataTable.isDataTable('#tblDet')) $('#tblDet').DataTable().destroy()

            const t = $('#tblDet').DataTable({
                scrollX: true,
                data: Module.setData.getLocalStorageData() === null ? [] : Module.setData.getLocalStorageData(),
                columnDef: [
                    { target: 2, whiteSpace: "nowrap" }
                ],
                columns: [
                    {
                        data: null, render: (d, t, r, m) => {
                            const bt = `<span data-idx='${m.row}' class="btn btn-xs btn-danger btn-circle ico fa fa-remove"></span>`
                            return bt
                        }
                    },
                    {
                        data: "stok", render: (data, type, row) => {
                            return data[0].Uraian
                        }
                    },
                    {
                        data: "stok", render: (data, type, row) => {
                            return data[0].Ukuran
                        }
                    },
                    {
                        data: "stok", render: (data, type, row) => {
                            return data[0].Satuan
                        }
                    },
                    {
                        data: "detail", render: (data, type, row) => {
                            if (data[0] === null) return 0
                            return data[0].kurang
                        }
                    },
                    {
                        data: "detail", render: (data, type, row) => {
                            return data[1].kurang
                        }
                    },
                    {
                        data: "detail", render: (data, type, row) => {
                            return data[2].kurang
                        }
                    },
                    {
                        data: "detail", render: (data, type, row) => {
                            return data[3].kurang
                        }
                    },
                    {
                        data: "detail", render: (data, type, row) => {
                            return data[4].kurang
                        }
                    },
                    {
                        data: "detail", render: (data, type, row) => {
                            return data[5].kurang
                        }
                    },
                    {
                        data: "detail", render: (data, type, row) => {
                            let jml = data.reduce((r, a) => {
                                r += parseFloat(a.kurang)
                                return r
                            }, 0)
                            return jml
                        }
                    },
                    {
                        data: "detail", render: (data, type, row) => {
                            let jml = data.reduce((r, a) => {
                                r += parseFloat(a.kurang)
                                return r
                            }, 0)
                            return (jml / 6).toFixed(2)
                        }
                    },
                    {
                        data: "stok", render: (data, type, row) => {
                            return data[0].jumlah
                        }
                    },
                    { data: "diminta" }
                ]
            })

            // t.on('order.dt search.dt', function () {
            //     t.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
            //         cell.innerHTML = i + 1;
            //     });
            // }).draw();
        }
    }
}

export { Module as FormInput }

// Module.init()

$('#frm').on('submit', e => {
    if (!e.isDefaultPrevented()) Module.action.simpan()
    e.preventDefault()
    return false
})

$('#tblDet').on('click', 'span.btn', (e) => {
    const c = confirm('Akan menghapus detail pesanan?')
    if (!c) return
    const raw = e.target.dataset.idx
    Module.setData.removeDetail(raw)
})

$('#btBatal').on('click', Module.action.reset)