document.addEventListener('DOMContentLoaded', () => {


    document.modalMessage = $('#modalMessage');
    const modalMessageStartHeader = document.modalMessage.find('h3').text();
    const modalMessageStartBody = document.modalMessage.find('.modal-body');
    const modalMessageStartFooter = document.modalMessage.find('.modal-footer');


    document.modalMessage.on('hidden.bs.modal', () => {
        document.modalMessage.find('h3').text(modalMessageStartHeader);
        document.modalMessage.find('.modal-body').replaceWith(modalMessageStartBody);
        document.modalMessage.find('.modal-footer').replaceWith(modalMessageStartFooter);
    });


    document.modalMessageShow = (header, body) => {
        document.modalMessage.find('h3').text(header);
        document.modalMessage.find('.modal-body').replaceWith(body);
        document.modalMessage.modal('show');
    }


    document.modalMessageErrorShow = () => {
        document.modalMessage.find('h3').text('Что то пошло не так...');
        document.modalMessage.find('.modal-body').replaceWith('<div class="modal-body"><div class="form-modal form"><div  class="title-h4 text-secondary">Наши специалисты уже работают над устранение проблемы.</div></div>');
        document.modalMessage.find('.modal-footer').replaceWith('<div class="modal-footer"> Пожалуйста, попробуйте позже.</div>');
        document.modalMessage.modal('show');
    }

});
