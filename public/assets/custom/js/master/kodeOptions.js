import { Api } from "../core/api.js"

const Module = {
    setOptions: async () => {

        let str = ""
        const getItem = await Api.optionDataBuilder("JenisBarang")
        getItem.map(i => {
            str += `<option value="${i.kode}">${i.nama}</option>`
        })
        $('#kode').append(str)
    }
}

export { Module as Kodes }