<?php namespace App\Services\FormProcessors\Review;

use App\Services\FormProcessors\CreateUpdateFormProcessor;

class AdminReviewFormProcessor extends CreateUpdateFormProcessor
{

    public function prepareInputData(array $data)
    {
        if (!empty($data['review_date'])) {
            $data['review_date'] = date('Y-m-d H:i:s', strtotime($data['review_date']));
        } else {
            $data['review_date'] = date('Y-m-d H:i:s');
        }

        if (!\Arr::get($data, 'ip')) {
            $data['ip'] = \Request::getClientIp();
        }

        return $data;
    }

}
