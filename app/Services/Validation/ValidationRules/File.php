<?php namespace App\Services\Validation\ValidationRules;

use Arr;
use Diol\Fileclip\InputFileWrapper\WrapperFactory\HttpFileFactory;
use Illuminate\Validation\Validator;
use Illuminate\Validation\Factory as ValidatorFactory;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File
{
    /** @var ValidatorFactory */
    private $validatorFactory;

    public function __construct(ValidatorFactory $validatorFactory)
    {
        $this->validatorFactory = $validatorFactory;
    }

    public function validateLocalOrRemoteFile($attribute, $value, $parameters, Validator $validator): bool
    {
        $attributeName = trans("validation.attributes.{$attribute}");

        $customAttributeKey = collect($validator->customAttributes)
            ->keys()
            ->first(function ($customAttribute) use ($attribute) {
                return fnmatch($customAttribute, $attribute);
            });

        if ($customAttributeKey) {
            $attributeName = Arr::get($validator->customAttributes, $customAttributeKey);
        }

        if ($value instanceof UploadedFile) {
            $imageValidator = $this->validatorFactory->make(
                ['file' => $value],
                ['file' => 'mimes:' . implode(',', $parameters)]
            );

            if ($imageValidator->fails()) {
                $message = $imageValidator->errors()->get('file')[0];
                $message = str_replace('file', $attributeName, $message);

                $validator->getMessageBag()->add($attribute, $message);
                return false;
            }
            return true;

        } else {
            $urlValidator = $this->validatorFactory->make(['url' => $value], ['url' => 'url']);

            if ($urlValidator->passes()) {
                $httpFile = (new HttpFileFactory(resolve('fileclip.http_client')))->getWrapper($value);
                if (in_array($httpFile->getExtension(), $parameters, true)) {
                    return true;
                }

                $message = str_replace(
                    [':attribute', ':values'],
                    [$attributeName, implode(', ', $parameters)],
                    trans('validation.mimes')
                );
                $validator->getMessageBag()->add($attribute, $message);
                return false;

            } else {
                $message = $urlValidator->errors()->get('url')[0];
                $validator->getMessageBag()->add($attribute, $message);
                return false;
            }
        }
    }
}
