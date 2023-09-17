
export class InputModal {
    constructor({title= 'Modal', inputType= 'text', callback, value = ""}) {
        this.title = title;
        this.inputType = inputType;
        this.callback = callback;

        const modalDiv = document.createElement('div');
        modalDiv.className = 'modal';
        modalDiv.tabIndex = -1;

        const dialogDiv = document.createElement('div');
        dialogDiv.className = 'modal-dialog modal-dialog-centered';

        const contentDiv = document.createElement('div');
        contentDiv.className = 'modal-content';

        const titleElement = document.createElement('h3');
        titleElement.className = 'modal-title';
        titleElement.textContent = this.title;

        const bodyDiv = document.createElement('div');
        bodyDiv.className = 'modal-body';

        const inputElement = document.createElement('input');
        inputElement.type = this.inputType;
        inputElement.value = value
        inputElement.className = "form-control my-2"

        const actionDiv = document.createElement('div');
        actionDiv.className = 'd-flex align-items-center justify-content-end gap-2';

        const cancelButton = document.createElement('button');
        cancelButton.type = 'button';
        cancelButton.className = 'btn btn-secondary';
        cancelButton.textContent = 'Abbrechen';
        cancelButton.onclick = () => {
            this.hide()
        };

        const saveButton = document.createElement('button');
        saveButton.type = 'button';
        saveButton.className = 'btn btn-primary';
        saveButton.textContent = 'Bestätigen';
        saveButton.onclick = () => {
            this.callback(inputElement.value);
            this.hide();
        };

        bodyDiv.appendChild(titleElement);
        bodyDiv.appendChild(inputElement);
        bodyDiv.appendChild(actionDiv)

        actionDiv.appendChild(cancelButton)
        actionDiv.appendChild(saveButton)

        contentDiv.appendChild(bodyDiv);

        dialogDiv.appendChild(contentDiv);
        modalDiv.appendChild(dialogDiv);

        document.body.appendChild(modalDiv);

        this.modal = new bootstrap.Modal(modalDiv);
        this.inputElement = inputElement
        this.modalElement = modalDiv
    }

    show(){
        this.modal.show()
    }

    hide() {
        this.inputElement.value = ''
        this.modal.hide()
        this.modalElement.remove()
    }
}