import { Api } from "../core/api.js"
import { MainApp } from "../core/main.js"
import { FormInput } from "./form.js"

// #cache disabled

let data = null

const Module = {
    init: () => {
        // Module.action.cari()
        Module.setData.table()
        MainApp.viewForm.show('box-table')
        MainApp.viewForm.hide('box-form')
    },
    action: {
        hapus: async (id) => {
            const res = await Api.delete('Persediaan/Order', id)
            Module.action.cari()
            console.log(res)
        },
        acc: async (id) => {
            const c = confirm('Yakin akan menjadikan Final? \n data tidak bisa dihapus setelah acc')
            if (c === false) return
            const res = await Api.put('Persediaan/Order', id, { proses: 1 })
            if (res !== null) toastr['success'](res.message)
            Module.action.cari()
        }
    },
    setData: {
        table: () => {
            if ($.fn.DataTable.isDataTable('#tbl')) $('#tbl').DataTable().destroy()
            $('#tbl').DataTable({
                // scrollX: true,
                // processing: true,
                // data: data,
                ajax:`${MainApp.apiUri}/API/Persediaan/Order`,
                processing: true,
                serverSide: true,
                scrollX: true,
                order: [[1, "desc"]],
                columnDefs:[
                    { targets: 0, orderable: false, searchable: false, className: "dt-body-nowrap" },
                    { targets: [1,2,3,4,5,6], orderable: true, searchable: true, className: "dt-body-nowrap" },
                    // { targets: 2, orderable: true, searchable: true, className: "dt-body-nowrap" },
                    // { targets: 3, orderable: true, searchable: true, className: "dt-body-nowrap" },
                    // { targets: 4, orderable: true, searchable: true, className: "dt-body-nowrap" },
                    // { targets: 5, orderable: true, searchable: true, className: "dt-body-nowrap" },
                    // { targets: 6, orderable: true, searchable: true, className: "dt-body-nowrap" },
                ],
                columns: [
                    {
                        title: "Action", 
                        data: 'id', 
                        render: (data, type, row) => {
                            const btLihat = Module.btnBuilder('cetak', data)
                            const btHapus = Module.btnBuilder('hapus', data)
                            const btAcc = Module.btnBuilder('acc', data)
                            return `<div style='display:flex; gap:4px;'>${btLihat} ${btHapus} ${btAcc}</div>`
                        },
                    },
                    { title: "Tanggal", data: 'tgltrans' },
                    { title: "Nomor", data: 'nomor' },
                    { title: "Perihal", data: 'perihal' },
                    { title: "Supervisor", data: 'spv_nama' },
                    { title: "Direksi", data: 'direksi_nama' },
                    { title: "Dibuat Oleh", data: 'created_by_name' },
                ]
            })
        }
    },
    btnBuilder:(action, data)=>{
        let classes
        
        switch(action){
            case 'cetak':
                classes= 'btn btn-xs btn-circle btn-success ico fa fa-eye'
                break
            case 'hapus':
                classes= 'btn btn-xs btn-circle btn-danger ico fa fa-remove'
                break
            case 'acc': 
                classes= 'btn btn-xs btn-circle btn-warning ico fa fa-check'
                break
        }

        return `<button 
                    type='button'
                    data-action='${action}' 
                    data-id='${data}' 
                    class='${classes}' 
                    data-bs-toogle='tooltip'
                    data-bs-placement='top' 
                    title='${action}'
                />`
    }
}

export { Module as Orders }

Module.init()

$('#btBuatOrder').on('click', () => {
    MainApp.viewForm.hide('box-table')
    MainApp.viewForm.show('box-form')
    FormInput.init()
})

$("#tbl").on('click', 'button', (e) => {
    const action = e.target.dataset.action
    const id = e.target.dataset.id
    switch (action) {
        case 'hapus':
            Module.action.hapus(id)
            break
        case "cetak":
            window.open(`${MainApp.baseUri}/Cetak/Order/${id}`)
            break
        case "acc":
            Module.action.acc(id)
            break
    }
    // if (action === 'hapus') return Module.action.hapus(id)
    // window.open(`${MainApp.baseUri}/Cetak/Order/${id}`)
})