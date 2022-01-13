function formatSizeUnits(bytes) {
    if (bytes >= 1073741824) {
        bytes = (bytes / 1073741824).toFixed(2) + ' GB';
    } else if (bytes >= 1048576) {
        bytes = (bytes / 1048576).toFixed(2) + ' MB';
    } else if (bytes >= 1024) {
        bytes = (bytes / 1024).toFixed(2) + ' KB';
    } else if (bytes > 1) {
        bytes = bytes + ' bytes';
    } else if (bytes == 1) {
        bytes = bytes + ' byte';
    } else {
        bytes = '0 byte';
    }
    return bytes;
}

document.addEventListener("DOMContentLoaded", function(event) {
    // в случае если нужно будет указать разные форматы, вынесите в дату атрибут regex и .text-muted (показывает выбранный файл)
    $('input[type=file]').change(function () {
        const fileSize = this.files[0].size;
        let val = $(this).val().toLowerCase(),
            regex = new RegExp("(.*?)\.(docx|doc|pdf|xls|jpg|jpeg)$");

        if ($(this).val()) {
            var filename = $(this).val();
            $(this).parent('.custom-file').find('.text-muted').html(filename.split(/\\|\//g).pop());
        }

        if (!(regex.test(val))) {
            $(this).val('');
            $(this).parent().find('.invalid-feedback.type').show();
        } else {
            $(this).parent().find('.invalid-feedback.type').hide();

            if (fileSize > $(this).attr('size')) {
                $(this).val('');
                $(this).parent().find('.invalid-feedback.size')
                    .html(`Размер файла ${formatSizeUnits(fileSize)}. Максимально допустимый ${formatSizeUnits($(this).attr('size'))}`)
                $(this).parent().find('.invalid-feedback.size').show();
            } else {
                $(this).parent().find('.invalid-feedback.size').hide();
            }
        }
    });
});
