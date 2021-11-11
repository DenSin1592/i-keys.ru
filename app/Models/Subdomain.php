<?php

namespace App\Models;


class Subdomain extends \Eloquent
{
    protected $fillable = [
        'name',
        'city_name',

        'robots_txt',
        'google_analytics',
        'yandex_metrika',
        'live_internet',

        'header_template',
        'meta_title_template',
        'meta_description_template',
        'meta_keywords_template',
    ];
}
