<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Merge environments
    |--------------------------------------------------------------------------
    |
    | List of environments, where assets should be merged.
    |
     */
    'merge_environments' => ['production'],

    /*
    |--------------------------------------------------------------------------
    | Groups
    |--------------------------------------------------------------------------
    |
    | Groups of assets to run over a set of filters into an output file.
    | By default, all paths to files begin in the public_path() directory.
    | The order of asset definition is maintained in the output file.
    |
     */

    'groups' => [

        'client_css' => [
            'assets' => [
                'html/css/style.css',

                'css/client/auth_menu.css',
                'css/client/cart.css',
            ],
            'filters' => ['css_min', 'embed_css', 'strip_bom', 'css_url_rebase'],
            'output' => 'css/compiled/client.css'
        ],

        'client_js' => [
            'assets' => [
                'html/vendor/jquery/jquery-3.6.0.min.js',
                'html/vendor/popper/popper.min.js',
                'html/vendor/bootstrap-4.6.0/js/dist/util.js',
                'html/vendor/bootstrap-4.6.0/js/dist/collapse.js',
                'html/vendor/bootstrap-4.6.0/js/dist/tooltip.js',
                'html/vendor/bootstrap-4.6.0/js/dist/modal.js',
                'html/vendor/select2/select2.min.js',
                'html/vendor/jquery-ui-1.12.1.custom/jquery-ui.min.js',
                'html/vendor/jquery-ui-touch-punch-master/jquery.ui.touch-punch.min.js',

                '/js/common/jquery.inputmask.bundle.min.js',
                '/js/common/jquery.validate/jquery.validate.min.js',
                '/js/common/jquery.validate/additional-methods.min.js',
                '/js/common/jquery.validate/localization/messages_ru.min.js',
                '/js/common/window_size_helper.js',
                '/js/common/promise_queue.js',
                '/js/common/csrf.js',

                'html/js/forms.js',
                'html/js/tooltip.js',
                'html/js/filter.js',
                'html/js/offcanvas.js',

                'js/client/helpers/Arrays.js',
                'js/client/auth_menu.js',
                'js/client/quick_order.js',
                'js/client/modal_message.js',
                'js/client/filter.js',
                'js/client/cart/cart_init.js',
                'js/client/cart/cart_add.js',
                'js/client/cart/cart_remove.js',
                'js/client/cart/cart_update.js',
                'js/client/validation/phone-mask.js',
                'js/client/validation/validMethods.js',
                'js/client/assets/uploadFile.js',
                'js/client/cart/order/services/cartStepsOrder.js',
                'js/client/cart/order/main.js',

            ],
            'filters' => ['js_min', 'end_with_semicolon'],
            'output' => 'js/compiled/client.js'
        ],

        'admin_css' => [
            'assets' => [
                'vendor/twitter-bootstrap/css/bootstrap.min.css',
                'vendor/font-awesome/css/font-awesome.min.css',
                'vendor/twitter-bootstrap/css/bootstrap-theme.min.css',
                'vendor/fancybox/jquery.fancybox.min.css',
                'vendor/datetimepicker/css/jquery.datetimepicker.css',
                'vendor/select2/select2.min.css',
                'vendor/select2/select2-bootstrap.min.css',
                'vendor/jquery.dataTables/css/dataTables.bootstrap.css',
                'vendor/jquery.dataTables/css/fixedHeader.dataTables.min.css',
                'vendor/jquery.raty/jquery.raty.css',
                'css/admin/base.css',
                'css/admin/element_list.css',
                'css/admin/exchange.css',
                'css/admin/forms.css',
                'css/admin/guest.css',
                'css/admin/menu.css',
                'css/admin/admin_users.css',
                'css/admin/admin_roles.css',
                'css/admin/node_structure.css',
                'css/admin/settings.css',
                'css/admin/scrollable_container.css',
                'css/admin/select2_customisation.css',
                'css/admin/modal_associations.css',
                'css/admin/product_type_page.css',
                'css/admin/catalog_tree.css',
                'css/admin/associated_products.css',
                'css/admin/orders.css',
            ],
            'filters' => ['css_min', 'embed_css', 'strip_bom', 'css_url_rebase'],
            'output' => 'css/compiled/admin.css'
        ],

        'admin_js' => [
            'assets' => [
                'vendor/jquery-2.1.3.min.js',
                'vendor/jquery-ui.min.js',
                'vendor/twitter-bootstrap/js/bootstrap.min.js',
                'vendor/fancybox/jquery.fancybox.min.js',
                'vendor/tinymce/tinymce.min.js',
                'vendor/datetimepicker/js/jquery.datetimepicker.js',
                'vendor/select2/select2.min.js',
                'vendor/select2/i18n/ru.js',
                'vendor/jquery.raty/jquery.raty.js',
                'vendor/jquery.inputmask/jquery.inputmask.bundle.min.js',
                'vendor/js.cookie.js',
                'vendor/jquery.dataTables/js/jquery.dataTables.js',
                'vendor/jquery.dataTables/js/dataTables.bootstrap.js',
                'vendor/jquery.dataTables/js/dataTables.fixedHeader.min.js',
                'js/admin/jquery_init.js',
                'js/admin/inputmask.init.js',
                'js/admin/bootstrap_customization.js',
                'js/admin/action_bar.js',
                'js/admin/datetimepicker_init.js',
                'js/admin/fancybox.init.js',
                'js/admin/product_type_page.js',
                'js/admin/reviews.js',
                'js/admin/catalog_tree.js',
                'js/admin/menu.js',
                'js/admin/hooks.js',
                'js/admin/sortable_tree.js',
                'js/admin/admin_users.js',
                'js/admin/tinymce_init.js',
                'js/admin/structure.js',
                'js/admin/settings.js',
                'js/admin/file_upload.js',
                'js/admin/pagination.js',
                'js/admin/element_list.js',
                'js/admin/redirects.js',
                'js/admin/attributes.js',
                'js/admin/associated_products.js',
                'js/admin/modal_associations.js',
                'js/common/jquery_raty_init.js',
                'js/admin/exchange.js',
                'js/admin/orders.js',
            ],
            'filters' => ['js_min', 'end_with_semicolon'],
            'output' => 'js/compiled/admin.js'
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    |
    | Name => class key-values for filters to use.
    | The use of closure based filters are also possible.
    |
     */

    'filters' => [
        'css_min' => \Assetic\Filter\CssMinFilter::class,
        'embed_css' => \Diol\LaravelAssets\Filter\LimitedEmbedCss::class,
        'css_url_rebase' => \Diol\LaravelAssets\Filter\CssUrlRebase::class,
        'strip_bom' => \Diol\LaravelAssets\Filter\StripBomFilter::class,

        'js_min' => \Assetic\Filter\JSMinFilter::class,
        'end_with_semicolon' => \Diol\LaravelAssets\Filter\EndWithSemicolon::class,
    ],
];
