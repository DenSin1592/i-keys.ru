<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Языковые ресурсы для проверки значений
    |--------------------------------------------------------------------------
    |
    | Последующие языковые строки содержат сообщения по-умолчанию, используемые
    | классом, проверяющим значения (валидатором). Некоторые из правил имеют
    | несколько версий, например, size. Вы можете поменять их на любые
    | другие, которые лучше подходят для вашего приложения.
    |
    */

    'accepted' => 'Вы должны принять :attribute.',
    'active_url' => 'Поле :attribute содержит недействительный URL.',
    'after' => 'В поле :attribute должна быть дата после :date.',
    'after_or_equal' => 'В поле :attribute должна быть дата после или равняться :date.',
    'alpha' => 'Поле :attribute может содержать только буквы.',
    'alpha_dash' => 'Поле :attribute может содержать только буквы, цифры, дефис и нижнее подчеркивание.',
    'alpha_num' => 'Поле :attribute может содержать только буквы и цифры.',
    'array' => 'Поле :attribute должно быть массивом.',
    'before' => 'В поле :attribute должна быть дата до :date.',
    'before_or_equal' => 'В поле :attribute должна быть дата до или равняться :date.',
    'between' => [
        'numeric' => 'Поле :attribute должно быть между :min и :max.',
        'file' => 'Размер файла в поле :attribute должен быть между :min и :max Килобайт(а).',
        'string' => 'Количество символов в поле :attribute должно быть между :min и :max.',
        'array' => 'Количество элементов в поле :attribute должно быть между :min и :max.',
    ],
    'boolean' => 'Поле :attribute должно иметь значение логического типа.',
    'confirmed' => 'Поле :attribute не совпадает с подтверждением.',
    'date' => 'Поле :attribute не является датой.',
    'date_equals' => 'Поле :attribute должно быть датой равной :date.',
    'date_format' => 'Поле :attribute не соответствует формату :format.',
    'different' => 'Поля :attribute и :other должны различаться.',
    'digits' => 'Длина цифрового поля :attribute должна быть :digits.',
    'digits_between' => 'Длина цифрового поля :attribute должна быть между :min и :max.',
    'dimensions' => 'Поле :attribute имеет недопустимые размеры изображения.',
    'distinct' => 'Поле :attribute содержит повторяющееся значение.',
    'email' => 'Поле :attribute должно быть действительным электронным адресом.',
    'ends_with' => 'Поле :attribute должно заканчиваться одним из следующих значений: :values',
    'exists' => 'Выбранное значение для :attribute некорректно.',
    'file' => 'Поле :attribute должно быть файлом.',
    'filled' => 'Поле :attribute обязательно для заполнения.',
    'gt' => [
        'numeric' => 'Поле :attribute должно быть больше :value.',
        'file' => 'Размер файла в поле :attribute должен быть больше :value Килобайт(а).',
        'string' => 'Количество символов в поле :attribute должно быть больше :value.',
        'array' => 'Количество элементов в поле :attribute должно быть больше :value.',
    ],
    'gte' => [
        'numeric' => 'Поле :attribute должно быть больше или равно :value.',
        'file' => 'Размер файла в поле :attribute должен быть больше или равен :value Килобайт(а).',
        'string' => 'Количество символов в поле :attribute должно быть больше или равно :value.',
        'array' => 'Количество элементов в поле :attribute должно быть больше или равно :value.',
    ],
    'image' => 'Поле :attribute должно быть изображением.',
    'in' => 'Выбранное значение для :attribute ошибочно.',
    'in_array' => 'Поле :attribute не существует в :other.',
    'integer' => 'Поле :attribute должно быть целым числом.',
    'ip' => 'Поле :attribute должно быть действительным IP-адресом.',
    'ipv4' => 'Поле :attribute должно быть действительным IPv4-адресом.',
    'ipv6' => 'Поле :attribute должно быть действительным IPv6-адресом.',
    'json' => 'Поле :attribute должно быть JSON строкой.',
    'lt' => [
        'numeric' => 'Поле :attribute должно быть меньше :value.',
        'file' => 'Размер файла в поле :attribute должен быть меньше :value Килобайт(а).',
        'string' => 'Количество символов в поле :attribute должно быть меньше :value.',
        'array' => 'Количество элементов в поле :attribute должно быть меньше :value.',
    ],
    'lte' => [
        'numeric' => 'Поле :attribute должно быть меньше или равно :value.',
        'file' => 'Размер файла в поле :attribute должен быть меньше или равен :value Килобайт(а).',
        'string' => 'Количество символов в поле :attribute должно быть меньше или равно :value.',
        'array' => 'Количество элементов в поле :attribute должно быть меньше или равно :value.',
    ],
    'max' => [
        'numeric' => 'Поле :attribute не может быть более :max.',
        'file' => 'Размер файла в поле :attribute не может быть более :max Килобайт(а).',
        'string' => 'Количество символов в поле :attribute не может превышать :max.',
        'array' => 'Количество элементов в поле :attribute не может превышать :max.',
    ],
    'mimes' => 'Поле :attribute должно быть файлом одного из следующих типов: :values.',
    'mimetypes' => 'Поле :attribute должно быть файлом одного из следующих типов: :values.',
    'min' => [
        'numeric' => 'Поле :attribute должно быть не менее :min.',
        'file' => 'Размер файла в поле :attribute должен быть не менее :min Килобайт(а).',
        'string' => 'Количество символов в поле :attribute должно быть не менее :min.',
        'array' => 'Количество элементов в поле :attribute должно быть не менее :min.',
    ],
    'not_in' => 'Выбранное значение для :attribute ошибочно.',
    'not_regex' => 'Выбранный формат для :attribute ошибочный.',
    'numeric' => 'Поле :attribute должно быть числом.',
    'present' => 'Поле :attribute должно присутствовать.',
    'regex' => 'Поле :attribute имеет ошибочный формат.',
    'required' => 'Поле :attribute обязательно для заполнения.',
    'required_if' => 'Поле :attribute обязательно для заполнения, когда :other равно :value.',
    'required_unless' => 'Поле :attribute обязательно для заполнения, когда :other не равно :values.',
    'required_with' => 'Поле :attribute обязательно для заполнения, когда :values указано.',
    'required_with_all' => 'Поле :attribute обязательно для заполнения, когда :values указано.',
    'required_without' => 'Поле :attribute обязательно для заполнения, когда :values не указано.',
    'required_without_all' => 'Поле :attribute обязательно для заполнения, когда ни одно из :values не указано.',
    'same' => 'Значения полей :attribute и :other должны совпадать.',
    'size' => [
        'numeric' => 'Поле :attribute должно быть равным :size.',
        'file' => 'Размер файла в поле :attribute должен быть равен :size Килобайт(а).',
        'string' => 'Количество символов в поле :attribute должно быть равным :size.',
        'array' => 'Количество элементов в поле :attribute должно быть равным :size.',
    ],
    'starts_with' => 'Поле :attribute должно начинаться из одного из следующих значений: :values',
    'string' => 'Поле :attribute должно быть строкой.',
    'timezone' => 'Поле :attribute должно быть действительным часовым поясом.',
    'unique' => 'Такое значение поля :attribute уже существует.',
    'uploaded' => 'Загрузка поля :attribute не удалась.',
    'url' => 'Поле :attribute имеет ошибочный формат.',
    'uuid' => 'Поле :attribute должно быть корректным UUID.',

    // Custom validation messages
    'subset' => 'Поле :attribute должно содержать значения из множества: :variants.',
    'multi_key_exists' => 'Поле :attribute содержит некорректные значения',
    'multi_exists' => 'Поле :attribute содержит некорректные значения',
    'phone' => 'Поле :attribute должно содержать корректный телефонный номер. Пример: +7 (777) 777-77-77.',
    "email_list" => "Поле :attribute должно содержать список корректных e-mail адресов.",
    'more_than' => 'Поле :attribute должно быть больше :value.',
    'unique_among' => 'Поле :attribute должно быть уникальным.',
    'regular_expression' => 'Поле :attribute содержит некорректное регулярное выражение.',

    /*
    |--------------------------------------------------------------------------
    | Собственные языковые ресурсы для проверки значений
    |--------------------------------------------------------------------------
    |
    | Здесь Вы можете указать собственные сообщения для атрибутов.
    | Это позволяет легко указать свое сообщение для заданного правила атрибута.
    |
    | http://laravel.com/docs/validation#custom-error-messages
    | Пример использования
    |
    |   'custom' => [
    |       'email' => [
    |           'required' => 'Нам необходимо знать Ваш электронный адрес!',
    |       ],
    |   ],
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Собственные названия атрибутов
    |--------------------------------------------------------------------------
    |
    | Последующие строки используются для подмены программных имен элементов
    | пользовательского интерфейса на удобочитаемые. Например, вместо имени
    | поля "email" в сообщениях будет выводиться "электронный адрес".
    |
    */

    'attributes' => [
        'created_at' => 'Дата создания',
        'updated_at' => 'Дата редактирования',

        'name' => 'Название',
        'name_for_site' => 'Название для сайта',
        'header' => 'Заголовок',
        'meta_title' => 'Meta title',
        'meta_description' => 'Meta description',
        'meta_keywords' => 'Meta keywords',

        'username' => 'Имя пользователя',
        'password' => 'Пароль',
        'new_password' => 'Новый пароль',
        'password_confirmation' => 'Подтверждение пароля',
        'allowed_ips' => 'Разрешённые IP адреса',
        'active' => 'Активность',

        'position' => 'Позиция',
        'publish' => 'Публикация',
        'best_prod' => 'Лучший товар',
        'menu_top' => 'В верхнем меню',
        'menu_bottom' => 'В нижнем меню',
        'alias' => 'Псевдоним URL',
        'parent_id' => 'Родитель',
        'type' => 'Тип',
        'count_products' => 'Кол-во товаров',
        'top_content' => 'Содержимое вверху',
        'content_for_submenu' => 'Содержимое всплывающего меню',
        'content_for_links_type' => 'Ссылки типов над фильтром',
        'content' => 'Содержимое',
        'bottom_content' => 'Содержимое внизу',
        'extra_description' => 'Дополнительное описание',
        'path_to_icon' => 'Абсолютный путь до иконки (sprite.svg)',

        'catalog_type' => 'Тип каталога',
        'category_id' => 'Категория',
        'price' => 'Цена',
        'old_price' => 'Старая цена',

        'attribute_type' => 'Тип параметра',
        'units' => 'Единицы измерения',
        'use_in_filter' => 'Использовать в фильтре',
        'for_admin_filter' => 'Для фильтра администратора',
        'decimal_scale' => 'Количество знаков после запятой',
        'value' => 'Значение',
        'svg_path_sprite' => 'Путь к svg#sprite',
        'allowed_values' => 'Разрешённые значения',
        'icon_file' => 'Изображение',
        'filter_name' => 'Название для фильтра',
        'filter_category_id' => 'Категория для фильтра(Для товаров набранных вручную)',
        'product_list_way' => 'Способ формирования списка товаров',
        'filter_query' => 'Строка фильтра',
        'rule' => 'Правило',
        'url' => 'Ссылка',
        'code_1c' => 'Код 1с',
        'description' => 'Описание',
        'related_products' => 'Сопутствующие товары',
        'image_file' => 'Изображение',
        'image' => 'Изображение',
        'comment' => 'Комментарий',
        'keep_review_date' => 'Не перестраивать дату отзыва',
        'review_date' => 'Дата отзыва',
        'review_id' => 'id отзыва',
        'review_name' => 'Имя',
        'review_content' => 'Текст отзыва',
        'review_content_answer' => 'Ответ от магазина',
        'review_score' => 'Оценка',
        'email' => 'E-mail',
        'on_home_page' => 'Выводить на главной странице',
        'device_type' => 'Тип устройства',
        'user_agent' => 'Заголовок браузера',
        'payment_status' => 'Статус оплаты',
        'payment_method' => 'Способ оплаты',
        'delivery_method' => 'Способ доставки',
        'postcode' => 'Почтовый индекс',
        'region_id' => 'Регион',
        'city' => 'Город',
        'street' => 'Улица',
        'building' => 'Дом, корпус/строение',
        'flat' => 'Офис/квартира',
        'order_items' => 'Состав заказа',
        'count' => 'Количество',
        'sum' => 'Сумма',
        'not_chosen' => 'Не выбрано',
        'full_name' => 'ФИО',
        'phone' => 'Телефон',
        'status' => 'Статус',
        'id' => 'Номер',
        'exchange_status' => 'Статус обмена с 1С',
        '' => '',
        'existence' => 'Статус',

        'city_name' => 'Город',
        'header_template' => 'Шаблон вставки региона заголовка h1 {{REG_HEADER}}',
        'meta_title_template' => 'Шаблон вставки региона для title {{REG_TITLE}}',
        'meta_description_template' => 'Шаблон вставки региона для description {{REG_DESCRIPTION}}',
        'meta_keywords_template' => 'Шаблон вставки региона для keywords {{REG_KEYWORDS}}',
        'robots_txt' => 'robots.txt',
        'google_analytics' => 'Счетчик Google Analytics',
        'yandex_metrika' => 'Счетчик Yandex Metrika',
        'live_internet' => 'Счетчик LiveInternet',


        'value_first_size_cylinder' => 'Первый типоразмер, мм',
        'value_second_size_cylinder' => 'Второй типоразмер, мм',
    ],

    'services'=> [
        'name' => 'Услуга',
        'image' => 'Изображение'
    ],

    'model_attributes' => [
        'attribute' => [
            'hidden' => 'Скрытый атрибут',
        ],
        'category' => [
            'catalog_type' => [
                'image_are_important' => 'Картинка важнее',
                'characteristics_are_important' => 'Характеристики важнее',
            ]
        ],
        'exchange_status' => [
            \App\Models\Exchange\StatusConstants::NEW => 'Новый',
            \App\Models\Exchange\StatusConstants::CHANGED => 'Изменен',
            \App\Models\Exchange\StatusConstants::EXPORTED => 'Выгружен',
        ],
        'exchange' => [
            'type' => [
                \App\Models\ExchangeLog::TYPE_ERROR => 'ERROR',
                \App\Models\ExchangeLog::TYPE_CATEGORY => 'категории',
                \App\Models\ExchangeLog::TYPE_PRODUCT => 'товары',
                \App\Models\ExchangeLog::TYPE_ATTRIBUTE => 'параметры',
                \App\Models\ExchangeLog::TYPE_ATTRIBUTE_VALUE => 'значения параметров',
                \App\Models\ExchangeLog::TYPE_PRODUCT_IMAGE => 'изображения товаров',
                \App\Models\ExchangeLog::TYPE_CLIENT => 'клиенты',
                \App\Models\ExchangeLog::TYPE_ORDER => 'заказы',
            ],
        ],
        'device_type' => [
            \App\Services\Device\DeviceHelper::DEVICE_TYPE_DESKTOP => 'компьютер',
            \App\Services\Device\DeviceHelper::DEVICE_TYPE_TABLET => 'планшет',
            \App\Services\Device\DeviceHelper::DEVICE_TYPE_PHONE => 'телефон',
        ],
        'product' =>
            [
                'existence' => [
                    \App\Models\Product\ExistenceConstants::AVAILABLE => 'В наличии',
                    \App\Models\Product\ExistenceConstants::FOR_ORDER => 'Под заказ',
                    \App\Models\Product\ExistenceConstants::STOP_PRODUCTION => 'Снят с производства',
                ],
            ],
        'order' =>
            [
                'status' => [
                    \App\Models\Order\StatusConstants::NOVEL => 'Новый',
                    \App\Models\Order\StatusConstants::CANCELLED => 'Отменен',
                    \App\Models\Order\StatusConstants::PROCESSED => 'Обработан',
                    \App\Models\Order\StatusConstants::TRANSFERRED_TO_DELIVERY_SERVICE => 'Передан в службу доставки',
                    \App\Models\Order\StatusConstants::CLOSED => 'Закрыт',
                ],
                'type' => [
                    \App\Models\Order\TypeConstants::FROM_SITE => 'Заказ с сайта',
                    \App\Models\Order\TypeConstants::FAST => 'Быстрый заказ',
                ],
                'payment_status' => [
                    \App\Models\Order\PaymentStatusConstants::UNPAID => 'Не оплачен',
                    \App\Models\Order\PaymentStatusConstants::PAID => 'Оплачен',
                    \App\Models\Order\PaymentStatusConstants::PARTLY_PAID => 'Частично оплачен',
                ],
                'payment_method' => [
                    \App\Models\Order\PaymentMethodConstants::CASH => 'Оплата при получении',
                    \App\Models\Order\PaymentMethodConstants::CASHLESS => 'Онлайн оплата',
                    \App\Models\Order\PaymentMethodConstants::INVOICE => 'Счет на юр.лицо',
                ],
                'delivery_method' => [
                    \App\Models\Order\DeliveryMethodConstants::SELF_DELIVERY => 'Самовывоз из в магазина в Москве',
                    \App\Models\Order\DeliveryMethodConstants::COURIER => 'Доставка курьером по Москве и обл.',
                    \App\Models\Order\DeliveryMethodConstants::TRANSPORT_COMPANY => 'Доставка СДЭК',
                    \App\Models\Order\DeliveryMethodConstants::SELF_TRANSPORT_COMPANY => 'Самовывоз СДЭК',
                ],
                'icon_file' => 'Реквизиты',
                'document' => 'Карточка юр.лица',
            ],
    ]
];
