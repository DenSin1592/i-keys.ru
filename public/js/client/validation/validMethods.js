$.validator.addMethod("minLenghtPhone", function (value, element) {
        return value.replace(/\D+/g, '').length > 10;
    },
    "Номер телефона должен состоять из 11 цифр!");
$.validator.addMethod("requiredPhone", function (value, element) {
        return value.replace(/\D+/g, '').length > 1;
    },
    " Заполните это поле!!!");
