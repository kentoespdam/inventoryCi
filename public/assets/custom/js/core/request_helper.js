import { MainApp } from "./main.js"

const RequestHelper = {
    optionGenerator: (req) => {
        if (req.method === "GET" || req.method === "DELETE") {
            return {
                headers: {
                    "content-type": "application/json",
                    "x-token": MainApp.token()
                },
                method: req.method
            }
        }

        return {
            headers: {
                "content-type": (req._json === true) ? "application/json" : "application/x-www-form-urlencoded",
                "x-token": MainApp.token()
            },
            method: req.method,
            body: (req._json === true) ? JSON.stringify(req.formData) : req.formData
        }
    },
    requestGenerator: async (req) => {
        const option = RequestHelper.optionGenerator(req)
        const res = await fetch(req.uri, option)
        if (res.status === 401) return MainApp.logout()
        return res
    }
}

export { RequestHelper }