<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DataProviders\SettingsForm\SettingsForm;
use App\Services\FormProcessors\Settings\SettingsFormProcessor;

/**
 * Class SettingsController
 * Controller to manage settings.
 * @package Admin
 */
class SettingsController extends Controller
{
    /**
     * @var SettingsFormProcessor
     */
    private $settingsFormProcessor;

    /**
     * @var SettingsForm
     */
    private $settingsForm;

    public function __construct(
        SettingsFormProcessor $formProcessor,
        SettingsForm $settingsForm
    ) {
        $this->settingsFormProcessor = $formProcessor;
        $this->settingsForm = $settingsForm;
    }

    public function edit()
    {
        return \View::make('admin.settings.edit')->with('formData', $this->settingsForm->provideData());
    }

    public function update()
    {
        $this->settingsFormProcessor->updateAll(\Request::all());
        $errors = $this->settingsFormProcessor->errors();

        if (count($errors) > 0) {
            return \Redirect::route('cc.settings.edit')->withErrors($errors)->withInput();

        } else {
            return \Redirect::route('cc.settings.edit')->with('alert_success', 'Изменения сохранены');
        }
    }
}
