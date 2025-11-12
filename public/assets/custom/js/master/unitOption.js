import { Api } from "../core/api.js"

const Module = {
    setOption: async () => {
        const getItem = await Api.optionDataBuilder("Satker")
        
        let str = "";

        getItem.map(i => {
            str += `<option value="${i.Unit}">${i.nm_Unit}</option>`
        })
        
        $('#unit').append(str)
        $('#unit').val('0101').trigger('change')
    }
}

export { Module as Units }