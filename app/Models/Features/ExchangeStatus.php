<?php

namespace App\Models\Features;

use App\Models\Exchange\StatusConstants;

/**
 * Trait ExchangeStatus
 * @package App\Models\Features
 */
trait ExchangeStatus
{
    /**
     * Get fields that using in export
     *
     * @return array
     */
    abstract protected static function getExportedFields(): array;

    protected static function bootExchangeStatus()
    {
        self::creating(
            function (self $model) {
                if (empty($model->exchange_status)) {
                    $model->exchange_status = StatusConstants::NEW;
                }
            }
        );

        self::updated(
            function (self $model) {
                $dirty = array_filter(
                    $model->getDirty(),
                    function ($key) {
                        return in_array($key, self::getExportedFields());
                    },
                    ARRAY_FILTER_USE_KEY
                );
                if (count($dirty) > 0) {
                    $model->markExchangeStatusAsChanged();
                }
            }
        );
    }

    /**
     * Mark model exchange status as $status
     * use \DB::table update in order not to change update_at
     * and not to run handlers for Model update
     *
     * @param string $status
     * @return int
     */
    private function markExchangeStatusAs(string $status)
    {
        if ($this->exchange_status == $status) {
            return 0;
        }

        return \DB::table($this->getTable())
            ->where('id', $this->id)
            ->update(['exchange_status' => $status]);
    }

    /**
     * Mark model exchange status as changed
     * @return int
     */
    public function markExchangeStatusAsChanged()
    {
        return $this->markExchangeStatusAs(StatusConstants::CHANGED);
    }

    /**
     * Mark model exchange status as exported
     * @return int
     */
    public function markExchangeStatusAsExported()
    {
        return $this->markExchangeStatusAs(StatusConstants::EXPORTED);
    }
}