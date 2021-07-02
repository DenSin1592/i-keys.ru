<?php

return [
    // Storage section
    'storage' => [
        // storage root to save files
        'root' => public_path(),

        // url to storage root, by default it's app root url
        'root_url' => null,

        // path to store original files
        'original_root' => storage_path('app/fileclip'),
    ],

    // Names section
    'names' => [
        // name generator for versions of files, available variants: "original", "random", "through_numbering"
        'name_generator' => 'through_numbering',

        // prefix for generated file names when used "through numbering" name generator
        'filename_prefix' => '',
    ],

    // Images section
    'images' => [
        // local path to watermark image
        'watermark' => null,

        // imagine driver for processing of images, available variants: "gd", "imagick", "auto"
        'imagine_driver' => 'auto',
    ],

    // Local path to directory with models used to update attachment versions by default
    'models_root' => app_path('Models'),
];
