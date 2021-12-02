document.addEventListener('DOMContentLoaded', () => {

    let modalMessage = $('#modalMessage');
    let modalMessageStartHeader = modalMessage.find('h3').text();
    let modalMessageStartBody = modalMessage.find('.modal-body');
    let modalMessageStartFooter = modalMessage.find('.modal-footer');


    modalMessage.on('show.bs.modal', () => {
        modalMessage.find('.modal-body').replaceWith('<div class="modal-body"></div>');
        modalMessage.find('.modal-footer').replaceWith('<div class="modal-footer"></div>');
    });

    modalMessage.on('hidden.bs.modal', () => {
        setTimeout(() => {
                modalMessage.find('h3').text(modalMessageStartHeader);
                modalMessage.find('.modal-body').replaceWith(modalMessageStartBody);
                modalMessage.find('.modal-footer').replaceWith(modalMessageStartFooter);
            }, 500,
        )
    });

});


let modalMessageErrorShow = () => {
    let modalMessage = $('#modalMessage');
    modalMessage.find('h3').text('Что то пошло не так...');
    modalMessage.find('.modal-body').replaceWith('<div class="modal-body"><div class="form-modal form"><div  class="title-h4 text-secondary">Наши специалисты уже работают над устранение проблемы.</div></div>');
    modalMessage.find('.modal-footer').replaceWith('<div class="modal-footer"> Пожалуйста, попробуйте позже.</div>');
}
