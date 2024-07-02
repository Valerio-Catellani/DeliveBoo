import "./bootstrap";
import "~resources/scss/app.scss";
import * as bootstrap from "bootstrap";
import.meta.glob(["../img/**", "../fonts/**"]);

import { ColumnChart, LineChart, DonatChart, getData } from './chartjs.js';


//Dashboard
if (document.getElementById('restaurant-dashboard')) {
    await getData();
    ColumnChart();
    DonatChart();
    LineChart();
}


//REGISTRATION
document.querySelectorAll('#register-user-button').forEach((element) => {
    element.addEventListener('click', (event) => {
        event.preventDefault();

        //prendo i valori
        const Form = document.getElementById('registration-form');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('password-confirm');
        const checkboxes = document.querySelectorAll('.typologies-input');
        const atLeastOneChecked = Array.from(checkboxes).some((checkbox) => checkbox.checked);
        const checkBoxDiv = document.getElementById('typology_id');
        const requredFileds = document.querySelectorAll('[required]');

        //reset
        document.querySelectorAll('.alert-danger').forEach((errorBox) => {
            errorBox.remove();
        });

        //controllo che tutti i campi siano compilati
        requredFileds.forEach((field) => {
            if (!field.value) {
                const errorBox = document.createElement('div');
                errorBox.classList.add('alert', 'alert-danger', 'err-animation');
                errorBox.innerHTML = 'Tutti i campi con * sono obbligatori';
                field.parentNode.insertBefore(errorBox, field.nextSibling);
                field.classList.add('is-invalid', 'err-animation');
            }
        })

        //contorllo che le password siano uguali
        if (password.value !== confirmPassword.value) {
            const errorBox1 = document.createElement('div');
            errorBox1.classList.add('alert', 'alert-danger', 'err-animation');
            errorBox1.innerHTML = 'Le password non coincidono';

            const errorBox2 = document.createElement('div');
            errorBox2.classList.add('alert', 'alert-danger', 'err-animation');
            errorBox2.innerHTML = 'Le password non coincidono';

            // Inserire i messaggi di errore dopo i campi di input
            password.parentNode.insertBefore(errorBox1, password.nextSibling);
            confirmPassword.parentNode.insertBefore(errorBox2, confirmPassword.nextSibling);

            // Aggiungere la classe di errore ai campi di input
            password.classList.add('is-invalid', 'err-animation');
            confirmPassword.classList.add('is-invalid', 'err-animation');
        }

        //controllo che almeno un checkbox sia checked
        if (!atLeastOneChecked) {
            const errorBox = document.createElement('div');
            errorBox.classList.add('alert', 'alert-danger', 'err-animation');
            errorBox.innerHTML = 'Seleziona almeno una tipologia';
            checkBoxDiv.parentNode.insertBefore(errorBox, checkBoxDiv.nextSibling);
            checkBoxDiv.classList.add('is-invalid', 'err-animation');
        }

        if (password.value === confirmPassword.value && atLeastOneChecked) {
            createConfirmModal();
        }


        function createConfirmModal() {
            const HypeModal = document.createElement('div');
            HypeModal.classList.add('modal', 'fade');
            HypeModal.setAttribute('id', 'hype-modal');
            HypeModal.setAttribute('tabindex', '-1');
            HypeModal.setAttribute('aria-labelledby', 'exampleModalLabel');
            HypeModal.setAttribute('aria-hidden', 'true');
            let tmp = `<div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content container-table hype-shadow-white">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Conferma i Dati Inseriti</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        I dati inseriti, una volta inviati, non possono essere più modificati. Sicuro di volerli inviare?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="mine-custom-btn min-custom-btn-grey" data-bs-dismiss="modal">No, Torna Indietro</button>
                        <button type="button" class="mine-custom-btn modal-save-button bg-danger">Si, Invia</button>
                      </div>
                    </div>
                  </div>`
            HypeModal.innerHTML = tmp;
            document.body.appendChild(HypeModal);
            const myModal = new bootstrap.Modal(HypeModal)
            myModal.show();
            const btnSave = HypeModal.querySelector('.modal-save-button')
            btnSave.addEventListener('click', () => {
                Form.submit();
                HypeModal.remove();
            })
            const buttons = Array.from(HypeModal.getElementsByTagName('button'));
            buttons.forEach((button) => {
                button.addEventListener('click', () => {
                    HypeModal.remove();
                });
            });
        }

    })
})






//modals
document.querySelectorAll('.element-delete').forEach((element) => {
    element.addEventListener('click', (event) => {
        event.preventDefault();
        const ElementId = element.getAttribute('data-element-id');
        const ElementName = element.getAttribute('data-element-title');
        createModal(ElementId, ElementName);
        const HypeModal = document.getElementById('hype-modal');
        const myModal = new bootstrap.Modal(HypeModal)
        myModal.show();
        const btnSave = HypeModal.querySelector('.modal-delete-button')
        btnSave.addEventListener('click', () => {
            element.parentElement.submit();
            HypeModal.remove();
        })
        const buttons = Array.from(HypeModal.getElementsByTagName('button'));
        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                HypeModal.remove();
            });
        });
    })
})
function createModal(ElementId, ElementName) {
    const modal = document.createElement('div');
    modal.classList.add('modal', 'fade');
    modal.setAttribute('id', 'hype-modal');
    modal.setAttribute('tabindex', '-1');
    modal.setAttribute('aria-labelledby', 'exampleModalLabel');
    modal.setAttribute('aria-hidden', 'true');
    let tmp = `<div class="modal-dialog modal-dialog-centered">
            <div class="modal-content container-table hype-shadow-white">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Cancellazione elemento: ${ElementName}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Sei sicuro di voler eliminare <strong>${ElementName}</strong> ?
              </div>
              <div class="modal-footer">
                <button type="button" class="mine-custom-btn min-custom-btn-grey" data-bs-dismiss="modal">No, torna indietro</button>
                <button type="button" class="mine-custom-btn modal-delete-button bg-danger">Si, cancella</button>
              </div>
            </div>
          </div>`
    modal.innerHTML = tmp;
    document.body.appendChild(modal);
}

//prendo la casella di input
//controllo che esista e se c'è eseguo il codice sottostante

document.querySelectorAll('.upload_image').forEach((element) => {

    element.addEventListener('change', (event) => {
        //console.log(image.files[0]);
        //prendo l'elemento dove visualizzare la preview
        const preview = event.target.parentElement.parentElement.querySelector('.w-25').children[0];
        //creao un nuovo oggetto di tipo FileReader
        const reader = new FileReader();
        //leggo il contenuto del file
        reader.readAsDataURL(event.target.files[0]);
        reader.onload = function (event) {
            preview.src = event.target.result;
        };
    });
})

// sidebar-collapse
document.querySelectorAll('#hype-sidebar-collapse').forEach((element) => {
    element.addEventListener('click', (event) => {
        event.preventDefault();
        const HypeSidebar = document.getElementById('sidebar');
        document.querySelectorAll('.hype-text-collapse').forEach((element) => {
            element.classList.toggle('d-none');
        })
        HypeSidebar.classList.toggle('sidebard-collapse');
    })
})


