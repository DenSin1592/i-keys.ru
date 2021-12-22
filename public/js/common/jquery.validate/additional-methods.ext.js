(function () {
    $.validator.addMethod('phoneNumber', function (value) {
        // validation for phone number. server side: app/services/Validation/ValidationRules/Common.php, method: validatePhone
        if (value != '') {
            return /^(\+?\s*(7|8))(\s|\(|-)*\d{3}(\s|\)|-)*\d{3}(-|\s)*\d{2}(-|\s)*\d{2}$/.test(value);
        } else {
            return true;
        }
    }, 'Please enter a valid phone number.');

    $.validator.addMethod('maxSize', function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param)
    });
})();