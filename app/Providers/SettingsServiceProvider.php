<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Settings\SettingContainer;
use App\Services\Settings\SettingGroup;
use App\Services\Settings\SettingValue;
use App\Services\Settings\SettingGetter;

/**
 * Class ServiceProvider
 * Service provider for settings.
 * @package App\Service\Settings
 */
class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            SettingContainer::class,
            function () {
                $settingContainer = new SettingContainer;

                $general = new SettingGroup('Основные');
                $settingContainer->addSettingGroup($general);

                $general->addSettingValue(
                    new SettingValue(
                        'general.site_name',
                        'Название сайта',
                        'l-keys.ru',
                        'Используется в политике конфиденциальности, окне авторизации системы администрирования и т.д.',
                        SettingValue::TYPE_TEXT
                    )
                );

                $general->addSettingValue(
                    new SettingValue(
                        'general.company_name',

                        'Название компании',
                        'OOO "ЗАМКИ-КЛЮЧИ"',
                        'Используется в политике конфиденциальности.',
                        SettingValue::TYPE_TEXT
                    )
                );

                $general->addSettingValue(
                    new SettingValue(
                        'site_content.phone',
                        'Номер телефона',
                        '',
                        '',
                        SettingValue::TYPE_TEXT
                    )
                );

                $general->addSettingValue(
                    new SettingValue(
                        'site_content.wa_phone',
                        'Номер WhatsApp',
                        '',
                        '',
                        SettingValue::TYPE_TEXT
                    )
                );

                $general->addSettingValue(
                    new SettingValue(
                        'site_content.telegram_phone',
                        'Номер Telegram',
                        '',
                        '',
                        SettingValue::TYPE_TEXT
                    )
                );

                $notifications = new SettingGroup('Уведомления');
                $settingContainer->addSettingGroup($notifications);

                $notifications->addSettingValue(
                    new SettingValue(
                        'mail.feedback.address',
                        'Email обратной связи (кому)',
                        '',
                        'Адрес выводится также в шапке в футере',
                        SettingValue::TYPE_TEXT,
                        ['required', 'email']
                    )
                );

                $notifications->addSettingValue(
                    new SettingValue(
                        'mail.from.address',
                        'Е-mail отправителя (от кого)',
                        '',
                        str_replace(
                            '{app.name}',
                            \Config::get('app.name'),
                            'Если поле не заполнено, то используется почта <i>noreply@{app.name}</i>'
                        ),
                        SettingValue::TYPE_TEXT,
                        ['nullable', 'email']
                    )
                );

                $notifications->addSettingValue(
                    new SettingValue(
                        'mail.from.name',
                        'Имя отправителя (от кого)',
                        '',
                        str_replace(
                            '{app.name}',
                            \Config::get('app.name'),
                            'Если поле не заполнено, то используется <i>{app.name}</i>'
                        ),
                        SettingValue::TYPE_TEXT,
                        ['nullable']
                    )
                );

                $notifications->addSettingValue(
                    new SettingValue(
                        'mail.reply_to.address',
                        'Адрес для ответа в письмах посетителям сайта',
                        '',
                        'Если пользователь нажмет на кнопку "Ответить на письмо", то ответ будет отправлен на этот адрес',
                        SettingValue::TYPE_TEXT,
                        ['nullable', 'email']
                    )
                );

                /*$notifications->addSettingValue(
                    new SettingValue(
                        'mail.for_display.address',
                        'Email для отображения на сайте и в футере писем',
                        'diol-test@yandex.ru',
                        '',
                        SettingValue::TYPE_TEXT,
                        ['required', 'email']
                    )
                );*/

                $admin = new SettingGroup('Система администрирования');
                $settingContainer->addSettingGroup($admin);

                $admin->addSettingValue(
                    new SettingValue(
                        'admin.field_descriptions',
                        'Описания полей',
                        '',
                        '<div style="text-align: left; display: inline-block;">
                        <strong>Пример</strong>:<br />
                        <strong>Название:</strong> "описание названия"<br />
                        <strong>"Краткое содержимое":</strong> "Описание краткого содержимого"
                        </div>',
                        SettingValue::TYPE_TEXTAREA,
                        ['nullable']
                    )
                );

                $redirects = new SettingGroup('Редиректы');
                $settingContainer->addSettingGroup($redirects);

                $redirects->addSettingValue(
                    new SettingValue(
                        'redirects_rules',
                        'Правила редиректов',
                        [],
                        '<div style="text-align: left; display: inline-block;">
<i><strong>Формат описания правил</strong>: <br />
{правило} - регулярное выражение<br />
{ссылка} - целевая ссылка <br />
</i><br />
<strong>Пример правила редиректа</strong>:<br />
<i><br />
<span style="font-size: 14px;">^/catalog(/.*)?$&nbsp;&nbsp;&nbsp;<strong>></strong>&nbsp;&nbsp;&nbsp;/</span><br />
</i><br />
где<br />
^   - начало текста<br />
$   - конец текста<br />
()? - необязательная часть текста<br />
.*  - любой текст<br />
<br />
Данное правило соотвествует следующим адресам:<br />
/catalog<br />
/catalog/<br />
/catalog/category-1<br />
/catalog/category-2<br />
                        </div>',
                        SettingValue::TYPE_REDIRECTS
                    )
                );

                return $settingContainer;
            }
        );

        $this->app->singleton(
            'setting',
            function () {
                return $this->app->make(SettingGetter::class);
            }
        );
    }
}
