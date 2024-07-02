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











document.querySelectorAll('.element-delete').forEach((element) => {
    element.addEventListener('click', (event) => {
        console.log('elimino');
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
function createModal(ElementName) {
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



//register-animation
// document.querySelectorAll('#register-user-button1').forEach((element) => {
//     element.addEventListener('click', (event) => {
//         event.preventDefault();
//         const UserData = {
//             name: document.getElementById('name').value,
//             lastname: document.getElementById('lastname').value,
//             email: document.getElementById('email').value,
//             password: document.getElementById('password').value,
//             password_confirmation: document.getElementById('password-confirm').value
//         }
//         registration();
//         async function registration() {
//             try {
//                 // Esegui una richiesta POST usando Axios o fetch
//                 const response = await axios.post('/api/registeruser', UserData);
//                 console.log(response.data); // Gestisci la risposta dal server, se necessario
//                 alert('Registrazione completata con successo!');
//                 // Puoi fare altre azioni dopo la registrazione, come reindirizzare l'utente

//             } catch (error) {
//                 console.error('Errore durante la registrazione:', error);
//                 // Gestisci gli errori qui, ad esempio mostrando un messaggio di errore all'utente
//             }
//         }
//     })
// })