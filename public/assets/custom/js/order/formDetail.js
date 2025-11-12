import { Api } from "../core/api.js"
import { Invent } from "../master/inventoryOptions.js"
import { Kodes } from "../master/kodeOptions.js"
import { FormInput } from "./form.js"

let inv = {}
let invt = {}
let kode

const Module = {
    init: () => {
        Kodes.setOptions()
    },
    action: {
        cariDetail: async (unit, kdBarang) => {
            const tgl = $('#tgltrans').val()
            const kode = $('#kode').val()
            const inven = inv.reduce((r, a) => {
                if (a.Kode === kode && a.kdBarang === kdBarang) r = a
                return r
            }, {})
            $('#ukuran').val(inven.Ukuran)
            $('#satuan').val(inven.Satuan)
            const uri = `DetailOrder/${tgl}/${unit}/${kode}/${kdBarang}`
            const res = await Api.showList(uri)
            if (!res) return
            const totKeluar = res.data.detail.reduce((r, a) => {
                r += parseFloat(a.kurang)
                return r
            }, 0)
            $('#keluar').val(totKeluar)
            $('#rata').val((totKeluar / 6).toFixed(2))
            if (res.data.stok.length === 0) {
                const oi = JSON.parse($('#kdBarang :selected')[0].dataset.raw)
                const x = {
                    Uraian: oi.Uraian,
                    Ukuran: oi.Ukuran,
                    Satuan: oi.Satuan,
                    jumlah: 0
                }
                res.data.stok.push(x)
            }

            $('#jml').val(res.data.stok[0].jumlah)
            res.data.totKeluar = totKeluar
            invt = res.data
        },
        reset: () => {
            kode = $('#kode').val()
            $('#frmDetail')[0].reset()
            $('#modalDetail').modal('hide')
            $('#kode').val(kode).trigger('change');
        }
    },
    setData: {
        kdBarang: async (kode) => {
            inv = await Invent.setOptions(kode)
        }
    }
}

Module.init()

$('#btAddDetail').on('click', () => {
    $('#modalDetail').modal('show')
    setTimeout(() => {
        $('.select2').select2()
    }, 1000)
    const kode = $('#kode').val()
    Module.setData.kdBarang(kode)
})

$('#kode').on('change', e => {
    const kode = e.target.value
    Module.setData.kdBarang(kode)
})

$('#kdBarang').on('change', e => {
    const unit = $('#unit').val()
    const kdBarang = e.target.value
    Module.action.cariDetail(unit, kdBarang)
})

$('#frmDetail').on('submit', e => {
    invt.diminta = $('#minta').val()
    FormInput.setData.addDetail(invt)
    Module.action.reset()
})

$('#btBatalDetail').on('click', Module.action.reset)