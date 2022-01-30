'use strict'
document.addEventListener("DOMContentLoaded", function(event) {
    try {
        const MODAL_CDEK = $('.modal-cdek');

        const CdekModalWindow = {
            setText: function (title, text) {
                MODAL_CDEK.find('.modal-title').html(title);
                MODAL_CDEK.find('.modal-body').html('<p>'+text+'</p>');
            },
            open: function () {
                MODAL_CDEK.modal('show');
            },
            close: function () {
                MODAL_CDEK.modal('hide');
            }
        }

        function onChoose(wat) {
            const title ='Выбран пункт выдачи заказа ' + wat.id;
            const text = 'Цена ' + wat.price + "\n" +
                'Срок ' + wat.term + " дн.\n" +
                'Город ' + wat.cityName + ', Код города ' + wat.city;
            CdekModalWindow.setText(title, text);
            CdekModalWindow.open();
        }

        function onChooseProfile(wat) {
            const title = 'Выбрана доставка курьером в город ' + wat.cityName;
            const text = 'код города ' + wat.city + "\n" +
                'цена ' + wat.price + "\n" +
                'срок ' + wat.term + ' дн.'
            CdekModalWindow.setText(title, text);
            CdekModalWindow.open();
        }

        const orderWidjet = new ISDEKWidjet({
            showWarns: true,
            showErrors: true,
            showLogs: true,
            hideMessages: false,
            path: 'https://widget.cdek.ru/widget/scripts/',
            servicepath: 'https://widget.cdek.ru/widget/scripts/service.php', //ссылка на файл service.php на вашем сайте
            templatepath: 'https://widget.cdek.ru/widget/scripts/template.php',
            choose: true,
            popup: true,
            country: 'Россия',
            defaultCity: 'Уфа',
            cityFrom: 'Омск',
            link: false,
            hidedress: true,
            hidecash: true,
            hidedelt: false,
            detailAddress: true,
            region: true,
            apikey: '',
            goods: [{
                length: 10,
                width: 10,
                height: 10,
                weight: 1
            }],
            onChoose: onChoose,
            onChooseProfile: onChooseProfile
        });
        document.querySelectorAll('.cdek-popup').forEach(function (item) {
            item.addEventListener('click', function (event) {
                event.preventDefault();
                orderWidjet.open();
            })
        });
    } catch (e) {
        console.warn(e);
    }
});
