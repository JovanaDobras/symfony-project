
var btnDelete = document.querySelectorAll('.delete-user');
var btnDeleteClose = document.querySelectorAll('.delete-cancle');
var modalOverlay = document.querySelectorAll('.delete');


function deleteUser() {
    for(let btn of btnDelete){
        btn.addEventListener('click', function(e){
            let targetId = e.target.dataset.delete;

            openDeleteModal(targetId)
        })
    }
}
deleteUser();

function openDeleteModal(id) {
    for (let modal of modalOverlay) {
        let targetId = modal.dataset.deleteModal;
        if (targetId === id) {
            modal.classList.toggle('active')
        } else {

        }
    }
}

function closeDeleteUser() {
    for (let element of  btnDeleteClose) {
        element.addEventListener('click', function(event) {
            for (let modal of modalOverlay) {
                modal.classList.remove('active');
            }
        })
    }
}
closeDeleteUser();


var openDollarsModal = document.querySelectorAll('.modalDollarsOpen');
var modalDollars = document.querySelectorAll('.modalDollars');
var closeDollarsModal = document.querySelectorAll('.closeModalDollars');


function selectBtnDollars() {
    for(let btn of openDollarsModal){
        btn.addEventListener('click', function(e){
            let targetId = e.target.dataset.dollars;

            openModalDollars(targetId)
        })
    }
}
selectBtnDollars();

function openModalDollars(id) {
    for (let modal of modalDollars) {
        let targetId = modal.dataset.dollarsModal;
        if (targetId === id) {
            modal.classList.toggle('active')
        } else {

        }
    }
}

function closeModalDollars() {
    for (let element of  closeDollarsModal) {
        element.addEventListener('click', function(event) {
            for (let modal of modalDollars) {
                modal.classList.remove('active');
            }
        })
    }
}
closeModalDollars();



var openTimeModal = document.querySelectorAll('.openTimeModal');
var modalTime = document.querySelectorAll('.times');
var closeModal = document.querySelectorAll('.closeModalTime');

function openModalTIme() {
    for(let btn of openTimeModal){
        btn.addEventListener('click', function(e){
            let targetId = e.target.dataset.time;

            addClassmodalTime(targetId)
        })
    }
}
openModalTIme();

function addClassmodalTime(id) {
    for (let modal of modalTime) {
        let targetId = modal.dataset.timeModal;
        if (targetId === id) {
            modal.classList.toggle('active')
        } else {

        }
    }
}

function closeModalTime() {
    for (let element of  closeModal) {
        element.addEventListener('click', function(event) {
            for (let modal of modalTime) {
                modal.classList.remove('active');
            }
        })
    }
}
closeModalTime();


var openEditModal = document.querySelector('.openEditModal');
var modalEdit = document.querySelector('.modal-edit-user');
var closeEditModal = document.querySelector('.closeEdit');

if(openEditModal && modalEdit && closeEditModal){

    openEditModal.onclick = function() {
        modalEdit.style.display = "block";
    }

    closeEditModal.onclick = function() {
        modalEdit.style.display = "none";
    }

    window.onclick = function(event) {
        if(event.target == modalEdit){
            modalEdit.style.display = "none";
        }
    }
}


var openAddModal = document.querySelector('.addBtnUser');
var modalAdd = document.querySelector('.background-add-users');
var closeAddModal = document.querySelector('.closeAdd');


if(openAddModal && modalAdd && closeAddModal){

    openAddModal.onclick = function() {
        modalAdd.style.display = "block";
    }

    closeAddModal.onclick = function() {
        modalAdd.style.display = "none";
    }

    window.onclick = function(event) {
        if(event.target == modalAdd){
            modalAdd.style.display = "none";
        }
    }
}



