// Sortable trees
$(function () {
    $('[data-sortable-wrapper]').each(function (wrapperIndex, wrapperDom) {
        var sortableWrapper = $(wrapperDom);
        var sortableContainer = sortableWrapper.find('[data-sortable-container]');

        var refreshListButton = sortableWrapper.find('[data-sortable-refresh-list]');
        var refreshListUrl = refreshListButton.data('sortableRefreshList');

        var updateButton = sortableWrapper.find('[data-sortable-update-positions]');
        var updateUrl = updateButton.data('sortableUpdatePositions');


        var controls = {
            disable: function () {
                sortableWrapper.find('.sorting-control').removeClass('enabled');
            },
            enable: function () {
                sortableWrapper.find('.sorting-control').addClass('enabled');
            }
        };


        var makeSortable = function () {
            sortableWrapper.find('[data-sortable-group]').sortable({
                handle: '[data-sortable-handler]',
                update: function (event, ui) {
                    controls.enable();
                    refreshPositions($(this));
                }
            });
        };


        var refreshPositions = function (sortable_group) {
            var positions = [], sortableInputs;

            sortableInputs = sortable_group.find('[data-sortable-input]').not(sortable_group.find('[data-sortable-group] [data-sortable-input]'));
            sortableInputs.each(function (inputIndex, input) {
                positions.push(parseInt($(input).val(), 10));
            });

            positions.sort(function (a, b) {
                return a - b;
            });

            sortableInputs.each(function (inputIndex, input) {
                $(input).val(positions[inputIndex]);
            });
        };


        var refreshList = function () {
            $.ajax({
                async: false,
                cache: false,
                url: refreshListUrl,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log(response['element_list']);
                    sortableContainer.html(response['element_list']);
                    makeSortable();
                }
            });
            controls.disable();
        };


        var updatePositions = function () {
            var positions = {};

            sortableContainer.find('[data-element-id]').each(function (inputIndex, inputDom) {
                var jInput = $(inputDom);
                var sortableInput = jInput.find('[data-sortable-input]');
                var elementId = jInput.data('elementId');

                positions[elementId] = sortableInput.val();
            });

            $.ajax({
                async: false,
                url: updateUrl,
                type: 'PUT',
                data: {positions: positions}
            }).then(function () {
                refreshList();
            });
        };


        sortableWrapper.on('click', '[data-sortable-group] [data-element-id] [data-sortable-button]', function () {
            var element = $(this).parents('[data-element-id]').eq(0);
            var sortableGroup = $(this).parents('[data-sortable-group]').eq(0);

            switch ($(this).data('sortableButton')) {
                case 'up':
                    var previous = element.prev();
                    if (previous.length === 1) {
                        element.insertBefore(previous);
                    }
                    refreshPositions(sortableGroup);
                    break;
                case 'down':
                    var next = element.next();
                    if (next.length === 1) {
                        element.insertAfter(next);
                    }
                    refreshPositions(sortableGroup);
                    break;
                default:
                    console.log('unknown direction');
                    break;
            }

            controls.enable();
        });


        sortableWrapper.on('keydown', '[data-sortable-input]', function (e) {
            if (e.shiftKey && e.keyCode == 9) { // shift + tab key
                return;
            }

            if (e.keyCode != 9) { // tab key
                controls.enable();
                if (e.keyCode == 13) { // enter key
                    updatePositions();
                }
            }
        });


        updateButton.on('click', function () {
            updatePositions()
        });


        refreshListButton.on('click', function () {
            refreshList();
        });


        makeSortable();
    });
});