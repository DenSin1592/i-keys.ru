(function ($) {
    $(document).ready(function () {
        var updateLogs = function (container, url) {
            if (!!container.data('_block')) {
                return;
            }

            container.addClass('loading');
            $.ajax({
                url: url,
                cache: false,
                dataType: 'html',
                success: function (result) {
                    container.html(result);
                    container.removeClass('loading');
                    container.data('_block', false);
                },
                error: function () {
                    container.removeClass('loading');
                    container.data('_block', false);
                }
            });
        };

        var importContainer = $('#import-container');
        if (importContainer.length === 1) {
            var importStatusContainer = importContainer.find('#import-status-container');
            var importLogsContainer = importContainer.find('#import-logs');
            var currentImportStatus = importContainer.data('currentStatus');

            if (importStatusContainer.length === 1) {
                setInterval(function () {
                    $.ajax({
                        url: importStatusContainer.data('updateStatusUrl'),
                        cache: false,
                        dataType: 'json',
                        success: function (result) {
                            importStatusContainer.html(result['import_status_block']);
                            if (currentImportStatus !== result['current_import_status']) {
                                currentImportStatus = result['current_import_status'];
                                importLogsContainer.find('a[data-logs-refresh]').show();
                            }
                        }
                    });
                }, 30000); //30 seconds
            }

            importLogsContainer.on('click', '.pagination a,a[data-logs-refresh]', function (e) {
                e.preventDefault();
                updateLogs(importLogsContainer, $(this).attr('href'));
            });
        }

        var exportContainer = $('#export-container');
        if (exportContainer.length === 1) {
            var exportStatusContainer = exportContainer.find('#export-status-container');
            var exportLogsContainer = exportContainer.find('#export-logs');
            var currentExportStatus = exportContainer.data('currentStatus');

            if (exportStatusContainer.length === 1) {
                setInterval(function () {
                    $.ajax({
                        url: exportStatusContainer.data('updateStatusUrl'),
                        cache: false,
                        dataType: 'json',
                        success: function (result) {
                            exportStatusContainer.html(result['export_status_block']);
                            if (currentExportStatus !== result['current_export_status']) {
                                currentExportStatus = result['current_export_status'];
                                exportLogsContainer.find('a[data-logs-refresh]').show();
                            }
                        }
                    });
                }, 30000); //30 seconds
            }

            exportLogsContainer.on('click', '.pagination a,a[data-logs-refresh]', function (e) {
                e.preventDefault();
                updateLogs(exportLogsContainer, $(this).attr('href'));
            });
        }
    });
})(jQuery);