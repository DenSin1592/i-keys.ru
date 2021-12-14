<?php namespace App\Services\Validation\Order;

use App\Models\Order\DeliveryMethodConstants;
use App\Models\Order\TypeConstants;
use App\Services\Repositories\Order\EloquentOrderRepository;
use App\Services\Validation\AbstractLaravelValidator;
use Illuminate\Validation\Factory as ValidatorFactory;
use Illuminate\Validation\Validator;

/**
 * Class OrderLaravelValidator
 * @package App\Services\Validation\Order
 */
class OrderLaravelValidator extends AbstractLaravelValidator
{
    /**
     * @var EloquentOrderRepository
     */
    private $orderRepository;

    public function __construct(
        ValidatorFactory $validatorFactory,
        EloquentOrderRepository $orderRepository
    ) {
        parent::__construct($validatorFactory);

        $this->orderRepository = $orderRepository;
    }

    /**
     * {@inheritDoc}
     */
    protected function getRules()
    {
        $rules = [
            'region_id' => ['nullable', 'exists:regions,id'],
            'name' => ['required'],
            'phone' => ['nullable', 'phone'],
            'email' => ['nullable', 'email'],
            'status' => ['in:' . implode(',', array_keys($this->orderRepository->getStatusVariants()))],
            'type' => ['in:' . implode(',', array_keys($this->orderRepository->getTypeVariants()))],
            'payment_method' => [
                'nullable',
                'in:' . implode(',', array_keys($this->orderRepository->getPaymentMethodVariants()))
            ],
            'payment_status' => [
                'nullable',
                'in:' . implode(',', array_keys($this->orderRepository->getPaymentStatusVariants()))
            ],
            'delivery_method' => [
                'nullable',
                'in:' . implode(
                    ',',
                    DeliveryMethodConstants::getMethodsForPayment(\Arr::get($this->data, 'payment_method'))
                )
            ],
            'order_items' => ['required'],
//            'icon_file' => 'mimes:jpg,pdf,doc,xls',
            'order_items.*.name' => ['required_without:order_items.*.code_1c'],
            'order_items.*.product_id' => ['exists:products,id'],
            'order_items.*.count' => ['required', 'integer', 'more_than:0'],
            'order_items.*.price' => ['numeric', 'min:0'],
            'exchange_status' => [
                'nullable',
                'in:' . implode(',', array_keys($this->orderRepository->getExchangeStatusVariants()))
            ],
        ];

        return $rules;
    }

    /**
     * {@inheritDoc}
     */
    protected function configValidator(Validator $validator)
    {
        parent::configValidator($validator);

        $addressRequired = function ($input) {
            return isset($input->delivery_method) &&
                $input->delivery_method != DeliveryMethodConstants::SELF_DELIVERY;
        };

//        $validator->sometimes('region_id', 'required', $addressRequired);
        $validator->sometimes('city', 'required', $addressRequired);
        $validator->sometimes('street', 'required', $addressRequired);
        $validator->sometimes('building', 'required', $addressRequired);

        $validator->sometimes(
            'phone',
            'required',
            function ($input) {
                return $input->type == TypeConstants::FAST;
            }
        );

        foreach (['payment_method', 'payment_status', 'delivery_method'] as $field) {
            $validator->sometimes(
                $field,
                'required',
                function ($input) {
                    return isset($this->currentId) || $input->type == TypeConstants::FROM_SITE;
                }
            );
        }
    }

    public function getAttributeNames()
    {
        return [
            'name' => trans('validation.attributes.full_name'),
            'order_items.*.name' => trans('validation.attributes.name'),
            'order_items.*.product_id' => trans('validation.attributes.product_id'),
            'order_items.*.count' => trans('validation.attributes.count'),
            'order_items.*.price' => trans('validation.attributes.price'),
        ];
    }

    public function getMessages()
    {
        return [
            'order_items.*.name.required_without' => 'Поле ' . trans('validation.attributes.name') .
                ' обязательно для заполнения, когда ' . trans('validation.attributes.code_1c') . ' не указан.'
        ];
    }
}
