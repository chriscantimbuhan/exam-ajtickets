<?php

namespace App\Actions;

trait HasModelTrait
{
    /**
     * @var mixed
     */
    protected $model;

    /**
     * Set the model instance.
     * 
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return static
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get the model instance.
     * 
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Check if the instance has model.
     * 
     * @return bool
     */
    public function hasModel()
    {
        return ! is_null($this->model);
    }
}
