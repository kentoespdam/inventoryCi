import { Api } from "../core/api.js"

const Module = {
    setOptions: async (kode) => {
        let str = `<option value="">--Pilih--</option>`
        $('#kdBarang').select2('destroy')
        $('#kdBarang').find('option').remove().end()
        const res = await Api.showList(`Inventory/${kode}/master`)
        if(res==null){
            $('#kdBarang').append(str)
            $('#kdBarang').select2({ width: 'resolve' })
            return
        }
        res.data.map(item => {
            str += `<option data-raw='${JSON.stringify(item)}' value='${item.kdBarang}'>${item.Uraian}</option>`
        })

        $('#kdBarang').append(str)
        $('#kdBarang').select2({ width: 'resolve' })
        return res.data
    }
}

export { Module as Invent }