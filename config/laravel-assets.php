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
                //
            ],
            'filters' => ['css_min', 'embed_css', 'strip_bom', 'css_url_rebase'],
            'output' => 'css/compiled/client.css'
        ],
        'client_js' => [
            'assets' => [
                //
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
                'css/admin/base.css',
                'css/admin/element_list.css',
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
