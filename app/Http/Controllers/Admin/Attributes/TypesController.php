<?php namespace App\Http\Controllers\Admin\Attributes;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Services\DataProviders\AttributeForm\AttributeForm;
use App\Services\Repositories\Attribute\EloquentAttributeRepository;

/**
 * Class TypesController
 * Controller to get specific data for attribute types.
 *
 * @package App\Http\Controllers\Admin\Attributes
 */
class TypesController extends Controller
{
    private $attributeRepository;
    private $attributeForm;

    public function __construct(EloquentAttributeRepository $attributeRepository, AttributeForm $attributeForm)
    {
        $this->attributeRepository = $attributeRepository;
        $this->attributeForm = $attributeForm;
    }


    public function show($id = null)
    {
        if (is_null($id)) {
            $attribute = $this->attributeRepository->newInstance();
        } else {
            $attribute = $this->getAttributeById($id);
        }
        $formData = $this->attributeForm->provideTypeDataFor($attribute, \Request::all());
        $content = \View::make('admin.attributes.form._type_data', ['formData' => $formData])->render();

        return \Response::json(['content' => $content]);
    }


    /**
     * Get attribute by id or abort application with 404 error.
     *
     * @param $id
     * @return Attribute
     */
    protected function getAttributeById($id)
    {
        $attribute = $this->attributeRepository->findById($id);
        if (is_null($attribute)) {
            \App::abort(404, "Attribute with id {$id} not found");
        }

        return $attribute;
    }
}
