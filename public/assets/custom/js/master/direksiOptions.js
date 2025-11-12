import { Api } from "../core/api.js"

const Module = {
    setOptions: async () => {
        let str = `<option value="">--Pilih--</option>`
        const res = await Api.showList('Pegawai/direksi')
        res.data.map(i => {
            str += `<option value="${i.nipam}">${i.nama}</option>`
        })
        $('#direksi').append(str)
    }
}

export { Module as Direksi }