<?php namespace App\Services\FormProcessors;

interface CrudFormProcessorInterface
{
    /**
     * Create an element.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function create(array $data = []);

    /**
     * Update an element.
     *
     * @param \Eloquent $model
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function update($model, array $data = []);

    /**
     * Get errors.
     *
     * @return array
     */
    public function errors();
}
