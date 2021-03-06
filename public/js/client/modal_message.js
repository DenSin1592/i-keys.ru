document.addEventListener('DOMContentLoaded', () => {


    document.modalMessage = $('#modalMessage');
    const modalMessageStartContent = document.modalMessage.html();


    document.modalMessage.on('hidden.bs.modal', () => {
        document.modalMessage.html(modalMessageStartContent);
    });


    document.modalMessageShow = async (header, body) => {
        closeAllModals().then(async () => {
            await new Promise((resolve, reject) => {setTimeout(resolve, 500)});
            document.modalMessage.find('h3').text(header);
            document.modalMessage.find('.modal-body').replaceWith(body);
            document.modalMessage.modal('show');
        }).then(() => {
            customNumberButtonInit();
        });
    };


    document.modalMessageShowNow = (header, body) => {
        document.modalMessage.find('h3').text(header);
        document.modalMessage.find('.modal-body').replaceWith(body);
        document.modalMessage.modal('show');
        setTimeout(() => {customNumberButtonInit();},500)
    };


    document.modalMessageErrorShow = async () => {
        closeAllModals().then(async () => {
            await new Promise((resolve, reject) => {setTimeout(resolve, 500)});
            document.modalMessage.find('h3').text('Что то пошло не так...');
            document.modalMessage.find('.modal-body').replaceWith('<div class="modal-body"><div class="form-modal form"><div  class="title-h4 text-secondary">Наши специалисты уже работают над устранение проблемы.</div></div>');
            document.modalMessage.find('.modal-footer').replaceWith('<div class="modal-footer"> Пожалуйста, попробуйте позже.</div>');
            document.modalMessage.modal('show');
        });
    };


    let closeAllModals = async () => {
        await new Promise((resolve, reject) => {setTimeout(resolve, 300)});
        $('.modal').each((_, elem) => {
            $(elem).modal('hide');
        });
        await new Promise((resolve, reject) => {setTimeout(resolve, 300)});
    };


});
