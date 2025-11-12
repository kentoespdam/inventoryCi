import { Api } from "../core/api.js"

const Module = {
    setOptions: async () => {
        let str = ``
        const res = await Api.showList('Pegawai/manager')
        res.data.map(i => {
            if (i.org_code == 'BA9') str += `<option value="${i.nipam}">${i.nama}</option>`
        })
        $('#manager').append(str)
    }
}

export { Module as Mgr }