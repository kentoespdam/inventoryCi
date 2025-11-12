import { Api } from "../core/api.js"

const Module = {
    setOptions: async () => {
        let str = ``
        const res = await Api.showList('Pegawai/spv')
        res.data.map(i => {
            if (i.org_code == 'BA9.2') str += `<option value="${i.nipam}">${i.nama}</option>`
        })
        $('#spv').append(str)
    }
}

export { Module as Spv }