const MainApp = {
    baseUri: `${window.location.origin}`,
    apiUri: `${window.location.origin}`,//`http://report.laptop.net`,
    token: () => {
        const coki = document.cookie
        const cokiArr = coki.split("; ")
        const listCoki = cokiArr.reduce((r, a) => {
            const f = a.split("=")
            r[f[0]] = f[1]
            return r
        }, [])

        // if (listCoki.token === undefined) return window.location.href = "/Auth"
        return listCoki.token
    },
    formDatatoObj: frmData => {
        const obj = {}
        frmData.forEach((value, key) => {
            obj[key] = value;
        });
        return obj
    },
    serializeArrayToObj: arr => {
        const str = arr.reduce((d, x) => {
            d += `"${x.name}": "${x.value}",`
            return d
        }, "")
        const json = `{ ${str.substring(0, str.length - 1)}}`

        return JSON.parse(json)
    },
    viewForm: {
        show: id => {
            $(`#${id}`).show(1000)
            $('html, body').animate({
                scrollTop: $(`#${id}`).offset().top - 100
            }, 500)
        },
        hide: id => {
            $(`#${id}`).hide(1000)
            // $('html, body').animate({
            //     scrollTop: $(`#wrapper`).offset().top
            // }, 500)
        }
    },
    formatDuit: val => {
        let duit = new Intl.NumberFormat('en-ID', {
            style: 'currency',
            currency: 'IDR',
        }).format(val)
        return duit.replace('IDR', 'Rp.').replace('.00', '')
    },
    tgl: () => {
        const dt = new Date()
        const th = dt.getFullYear()
        const bl = (dt.getMonth() < 10 ? `0${dt.getMonth()}` : dt.getMonth())
        const hr = (dt.getDate() < 10 ? `0${dt.getDate()}` : dt.getDate())

        return `${th}-${bl}-${hr}`
    },
    jam: () => {
        const dt = new Date()
        const j = (dt.getHours() < 10 ? `0${dt.getHours()}` : dt.getHours())
        const m = (dt.getMinutes() < 10 ? `0${dt.getMinutes()}` : dt.getMinutes())
        const s = (dt.getSeconds() < 10 ? `0${dt.getSeconds()}` : dt.getSeconds())

        return `${j}:${m}:${s}`
    },
    escapeHtml(text) {
        let escapeChar = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        }
        return text.replace(/[&<>"']/g, function (m) { return escapeChar[m]; });
    },
    // disableEnter: () => {
    //     $('input').on('keypress', e => {
    //         if (e.keyCode === 13) {
    //             e.preventDefault()
    //         }
    //     })
    // },
    // loading: {
    //     show: () => {
    //         $('.loading_container').css('display', 'block');
    //     },
    //     hide: () => {
    //         $('.loading_container').css('display', 'none');
    //     }
    // },
    // Toast: Swal.mixin({
    //     toast: true,
    //     position: 'top-end',
    //     showConfirmButton: false,
    //     timer: 3000
    // }),
    logout: () => {
        document.cookie = 'token=null;expires=Thu, 01 Jan 1970 00:00:01 GMT'
        return window.location.href = "/"
    }

}

export { MainApp }