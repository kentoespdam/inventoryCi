import { Api } from "../core/api.js"

const Module = {
    setOptions: async (pegawai) => {
        let str = ``
        pegawai.data.map(item => {
            if (parseInt(item.pos_level) >= 5) str += `<option value="${item.nipam}">${item.nama} - (${item.jabatan})</option>`
        })
        $('#spv').append(str)
    }
}

export { Module as Spv }