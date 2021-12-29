document.addEventListener('DOMContentLoaded', () => {


    document.modalMessage = $('#modalMessage');
    const modalMessageStartContent = document.modalMessage.html();

    document.modalMessage.on('hidden.bs.modal', () => {
        document.modalMessage.html(modalMessageStartContent);
    });


    document.modalMessageShow = (header, body) => {
        document.modalMessage.find('h3').text(header);
        document.modalMessage.find('.modal-body').replaceWith(body);
        document.modalMessage.modal('show');
    }


    document.modalMessageErrorShow = () => {
        $('.modal').hide();
        document.modalMessage.html(modalMessageStartContent);
        document.modalMessage.find('h3').text('Что то пошло не так...');
        document.modalMessage.find('.modal-body').replaceWith('<div class="modal-body"><div class="form-modal form"><div  class="title-h4 text-secondary">Наши специалисты уже работают над устранение проблемы.</div></div>');
        document.modalMessage.find('.modal-footer').replaceWith('<div class="modal-footer"> Пожалуйста, попробуйте позже.</div>');
        document.modalMessage.modal('show');
    }

});
