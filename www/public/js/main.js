
class SvgIcon extends HTMLElement{
    constructor() {
        super();
        const icon_height = this.dataset.height
        const icon_width = this.dataset.width
        this.innerHTML = `<svg role="img" class="svg-icon icon-${this.dataset.icon} ${this.className}"><use xlink:href="${WWW_TOP}/public/images/symbols.svg#icon-${this.dataset.icon}"></use></svg>`;
        const child = this.childNodes[0];

        child.style.cssText += this.style.cssText;
        this.style.cssText = "";

        if (icon_height){
            child.style.setProperty('--icon-height', icon_height)
        }
        if (icon_width){
            child.style.setProperty('--icon-width',  icon_width)
        }


    }
}

customElements.define("svg-icon", SvgIcon);
