
import * as boostrapHelder from './helper/bootstrap.js'


function splitExtension(filename){
    let splitted = filename.split('.');
    let extension = splitted.pop();
    let name = splitted.join('.');

    return {name, extension};
}

function fetchAction(formData){
    fetch(WWW_TOP + '/actions-browser', {
        method: 'POST',
        body: formData
    }).then(response => {
        if (!response.ok) {
            return response.text().then(errorText => {
                throw new Error(errorText);
            });
        }
        location.reload();
    }).catch(error => {
        console.error("Error:", error)
        alert(error.message)
    });
}

function createFolder(){
    new boostrapHelder.InputModal({
        title: 'Ordner erstellen',
        callback: function (value){
            let formData = new FormData();
            formData.append('action', 'create-folder');
            formData.append('path', BROWSER_PATH);
            formData.append('newFolderName', value);

            fetchAction(formData)
        }
    }).show()
}

function renameFile(element){
    element = element.parentElement
    const file = splitExtension(element.dataset.name)

    new boostrapHelder.InputModal({
        title: 'Datei umbennen',
        callback: function (value){
            let formData = new FormData();
            formData.append('action', 'rename-file');
            formData.append('path', element.dataset.path);
            formData.append('newName', value + '.' + file.extension);

            fetchAction(formData)
        },
        value: file.name
    }).show()
}

function renameFolder(element){
    element = element.parentElement

    new boostrapHelder.InputModal({
        title: 'Datei umbennen',
        callback: function (value){
            let formData = new FormData();
            formData.append('action', 'rename-file');
            formData.append('path', element.dataset.path);
            formData.append('newName', value);

            fetchAction(formData)
        },
        value: element.dataset.name
    }).show()
}

function deleteFolder(element){
    element = element.parentElement
    const path = element.dataset.path
    let formData = new FormData();
    formData.append('action', 'delete-folder');
    formData.append('path', path);

    fetchAction(formData)
}

const actions = {
    'action-create-folder': createFolder,
    'action-rename-file': renameFile,
    'action-rename-folder': renameFolder,
    'action-delete-folder': deleteFolder
}

Object.entries(actions).forEach(([selector, action_function]) => {
    document.querySelectorAll('.' +  selector).forEach(element => {
        element.addEventListener('click', () => {
            action_function(element)
        })
    })
});

