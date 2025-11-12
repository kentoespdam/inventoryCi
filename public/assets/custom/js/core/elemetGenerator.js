const Elm = {
    option: (value, text, className = null) => {
        const opt = document.createElement('option')
        opt.setAttribute("value", value)
        const t = document.createTextNode(text)
        opt.appendChild(t)
        return opt
    }
}

export { Elm }