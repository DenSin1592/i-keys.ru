(function () {
    /**
     * Function to get new key to add new element.
     *
     * @param elements
     * @returns {number}
     */
    function getMaxKey(elements) {
        return Math.max.apply(Math, elements.map(function () {
            return $(this).data('elementKey')
        }).get());
    }

    $(document).on('click', '[data-element-list="add"]', function () {
        var toggle, loadElementUrl, containerSelector, container, maxKey, newKey;
        toggle = $(this);
        if (toggle.prop('disabled')) {
            return;
        } else {
            toggle.prop('disabled', true);
        }
        loadElementUrl = toggle.data('loadElementUrl');
        containerSelector = toggle.data('elementListTarget');
        container = $(containerSelector);
        var containerChildList = container.find('[data-element-list="element"]');
        if (containerChildList.length > 0) {
            maxKey = getMaxKey(containerChildList);
        } else {
            maxKey = 0;
        }
        newKey = (maxKey + 1);

        $.ajax({
            cache: false,
            type: 'GET',
            dataType: 'json',
            url: loadElementUrl,
            data: { key: newKey }
        }).then(function (result) {
            var jResult = $(result['element']);
            jResult.appendTo(container);
            tinymceInit(); // in case tinymce field inside of element
            toggle.prop('disabled', false);
        });
    });

    $(document).on('click', '[data-element-list="remove"]', function () {
        $(this).parents('[data-element-list="element"]').eq(0).remove();
    });

    $(document).on('click', '[data-element-list="element"] .toggle-full-info', function () {
        var element = $(this).parents('[data-element-list="element"]').eq(0);
        element.addClass('show-full-info');
        element.find('[data-full-info-state]').val(1);
    });

    $(document).on('click', '[data-element-list="element"] .toggle-short-info', function () {
        var element = $(this).parents('[data-element-list="element"]').eq(0);
        element.removeClass('show-full-info');
        element.find('[data-full-info-state]').val(0);
    })
})();