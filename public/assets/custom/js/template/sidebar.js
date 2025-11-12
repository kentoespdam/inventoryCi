import { menuitem } from "./menuitem.js"

const menunya = document.getElementById('menunya')

let str = ""
menuitem.map((item) => {
    const aClass = (item.subMenu) ? "waves-effect parent-item js__control" : "wave-effect";
    const arrow = (item.subMenu) ? `<span class="menu-arrow fa fa-angle-down"></span>` : ""
    str += `<li>
        <a href="${item.path}" class="${aClass}">
            <i class="${item.icon}"></i>
            <span>${item.title}</span>
            ${arrow}
        </a>`
    if (item.subMenu) {
        str += `<ul class="sub-menu js__content">`
        item.subMenu.map(itm => {
            str += `<li><a href="${itm.path}"> <i class="${itm.icon}"></i> ${itm.title}</a></li>`
        })
        str += `</ul>`
    }

    // ${
    // (item.subMenu) ?
    // `<ul class="sub-menu js__content">` +
    // item.subMenu.map(itm => {
    //     return `<li> <a href="${itm.path}">${itm.title}</a> </li>`
    // })
    // + `</ul>`
    // : ""
    // }
    str += `</li>`
})
menunya.innerHTML = str