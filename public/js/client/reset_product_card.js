document.addEventListener('DOMContentLoaded', function () {

    $(document).on('change', 'input.reset-card', (e) => {
        e.preventDefault();
        let input = $(e.currentTarget);
        let url = input.data('url');
        document.location.href = url;
    });

});

