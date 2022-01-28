'use strict'

document.addEventListener("DOMContentLoaded", function(event) {
    const orderWidjet = new ISDEKWidjet({
        popup: true,
        defaultCity: 'Казань',
        cityFrom: 'Казань',
        goods: [ // установим данные о товарах из корзины
            { length : 10, width : 20, height : 20, weight : 5 }
        ],
        onReady : function(){ // на загрузку виджета отобразим информацию о доставке до ПВЗ
            ipjq('#linkForWidjet').css('display','inline');
        },
        onChoose : function(info){ // при выборе ПВЗ: запишем номер ПВЗ в текстовое поле и доп. информацию
            ipjq('[name="chosenPost"]').val(info.id);
            ipjq('[name="addresPost"]').val(info.PVZ.Address);
            // расчет стоимости доставки
            var price = (info.price < 500) ? 500 : Math.ceil( info.price/100 ) * 100;
            ipjq('[name="pricePost"]').val(price);
            ipjq('[name="timePost"]').val(info.term);
            orderWidjet.close(); // закроем виджет
        }
    });
    console.info(orderWidjet);
});
