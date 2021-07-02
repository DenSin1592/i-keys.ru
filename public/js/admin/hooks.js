(function ($, document) {
    $(function () {
        // Confirmation hook
        $(document).on('click', '[data-confirm]', function (e) {
            if (!confirm($(this).data('confirm'))) {
                e.preventDefault();
                e.stopImmediatePropagation();
            }
        });

        // Toggle flags in list hook
        $(document).on('click', 'a.toggle-flag', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            var currentLink = $(this), container;
            container = currentLink.parent();
            currentLink.remove();
            container.html('<span class="glyphicon glyphicon-refresh"></span>');
            $.ajax({
                url: this.href,
                type: currentLink.data('method'),
                success: function (result) {
                    container.replaceWith(result['new_icon']);
                }
            });
        });


        // REST for links (DELETE, PUT)
        $(document).on('click', 'a[data-method]', function (e) {
            e.preventDefault();

            var form = document.createElement("form");
            form.setAttribute("method", 'post');
            form.setAttribute("action", this.href);

            if ($(this).attr('target') !== undefined) {
                form.setAttribute("target", $(this).attr('target'));
            }

            var methodField = document.createElement("input");
            methodField.setAttribute("type", "hidden");
            methodField.setAttribute("name", "_method");
            methodField.setAttribute("value", $(this).data('method'));
            form.appendChild(methodField);

            var tokenField = document.createElement("input");
            tokenField.setAttribute("type", "hidden");
            tokenField.setAttribute("name", "_token");
            tokenField.setAttribute("value", $('meta[name="csrf-token"]').attr('content'));
            form.appendChild(tokenField);

            document.body.appendChild(form);
            form.submit();
        });
    });


    // Global handler for all ajax requests
    $(document).ajaxComplete(function (event, xhr) {
        if (xhr.status === 401) { // reload if unauthorized
            window.location.reload();
        }
    });
})(jQuery, document);
