import { MainApp } from "./main.js"
import { RequestHelper } from "./request_helper.js"

const Api = {
    showList: async (uri) => {
        NProgress.start()
        const req = {
            uri: `${MainApp.apiUri}/API/${uri}`,
            method: "GET"
        }

        const res = await RequestHelper.requestGenerator(req)
        NProgress.done()
        if (res.status !== 200) {
            toastr['error'](res.statusText)
            return null
        }
        const res_json = await res.json()

        return res_json
    },
    findById: async (uri, id) => {
        NProgress.start()
        const req = {
            uri: `${MainApp.apiUri}/API/${uri}/${id}`,
            method: "GET"
        }

        const res = await RequestHelper.requestGenerator(req)
        NProgress.done()
        if (res.status !== 200) {
            toastr['error'](res.statusText)
            return null
        }
        const res_json = await res.json()

        return res_json
    },
    post: async (uri, data, _json = true) => {
        const req = {
            uri: `${MainApp.apiUri}/API/${uri}`,
            method: "POST",
            _json: _json,
            formData: data
        }

        const res = await RequestHelper.requestGenerator(req)
        NProgress.done()
        if (res.status !== 201) {
            console.log(await res.json())
            toastr['error'](res.statusText)
            return null
        }
        const res_json = await res.json()

        return res_json
    },
    edit: async (uri, id) => {
        const req = {
            uri: `${MainApp.apiUri}/API/${uri}/${id}/edit`,
            method: "GET"
        }

        const res = await RequestHelper.requestGenerator(req)
        const res_json = await res.json()

        return res_json
    },
    put: async (uri, id, data, _json = true) => {
        NProgress.start()
        const req = {
            uri: `${MainApp.apiUri}/API/${uri}/${id}`,
            method: "PUT",
            _json: _json,
            formData: data
        }
        const res = await RequestHelper.requestGenerator(req)
        NProgress.done()
        if (res.status !== 201) {
            toastr['error'](res.statusText)
            return null
        }
        const res_json = await res.json()

        return res_json
    },
    delete: async (uri, id) => {
        const x = confirm('Yakin Akan Menghapus Data?')
        if (x === false) return
        NProgress.start()
        const req = {
            uri: `${MainApp.apiUri}/API/${uri}/${id}`,
            method: "DELETE"
        }
        const res = await RequestHelper.requestGenerator(req)
        NProgress.done()
        if (res.status !== 201) {
            toastr['error'](res.statusText)
            return null
        }
        const res_json = await res.json()
        return res_json
    },
    optionDataBuilder: async (fUri, lItem) => {
        const res= await Api.showList(`${fUri}`)
        return res.data
    }
}

export { Api }
