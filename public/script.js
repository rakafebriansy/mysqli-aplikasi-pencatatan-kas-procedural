//MODAL BOX
document.addEventListener('click', (event) => {
    if (event.target.classList.contains('text-bg-danger')) {
        document.querySelector('#hapusModal .modal-footer > input').value = event.target.dataset.id;
    }
    if (event.target.classList.contains('text-bg-warning')) {
        let inputs = document.querySelectorAll('#ubahModal .modal-body .mb-3 input');

        let date = event.target.dataset.tanggal.split('/');
        date.reverse();
        console.log(date)
        inputs[0].value = event.target.dataset.nama;
        inputs[1].value = date.join('-');
        inputs[2].value = event.target.dataset.nominal;
        document.querySelector('#ubahModal .modal-footer > input').value = event.target.dataset.id;
    }
});