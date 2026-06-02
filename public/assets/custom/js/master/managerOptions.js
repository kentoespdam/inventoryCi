import { Api } from "../core/api.js"

const Module = {
    setOptions: async (pegawai) => {
        let str = ``
        pegawai.data.map(item => {
            if (item.pos_level == 4) str += `<option value="${item.nipam}">${item.nama} - (${item.jabatan})</option>`
        })
        $('#manager').append(str)
    }
}

export { Module as Mgr }