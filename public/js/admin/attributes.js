(function () {
    $(function () {
        // Attribute additional data, e.g. allowed value
        (function () {
            var attributeType, attributeTypeData, attributeTypeDataUrl;

            attributeType = $('#attribute_type');
            attributeTypeData = $('#attribute-type-data');
            if (attributeType.length === 1 && attributeTypeData.length === 1) {
                attributeTypeDataUrl = attributeTypeData.data('url');
                attributeType.on('change', function () {
                    $.ajax({
                        cache: false,
                        type: 'GET',
                        dataType: 'json',
                        url: attributeTypeDataUrl,
                        data: { attribute_type: this.value }
                    }).then(function (result) {
                        attributeTypeData.html(result['content']);
                    });
                });
            }
        })();
    });
})();