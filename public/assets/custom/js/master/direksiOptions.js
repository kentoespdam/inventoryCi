import { Api } from "../core/api.js"

const Module = {
    setOptions: async (pegawai) => {
        let str = `<option value="">--Pilih--</option>`
        pegawai.data.map(item => {
            if ([2, 3].includes(parseInt(item.pos_level))) str += `<option value="${item.nipam}">${item.nama} - (${item.jabatan})</option>`
        })
        $('#direksi').append(str)
    }
}

export { Module as Direksi }