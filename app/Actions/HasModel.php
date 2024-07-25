<?php

namespace App\Actions;

interface HasModel
{
    /**
     * Set the model instance.
     * 
     * @param mixed $model
     * @return static
     */
    public function setModel($model);

    /**
     * Get the model instance.
     * 
     * @return mixed
     */
    public function getModel();

    /**
     * Check if the instance has model.
     * 
     * @return bool
     */
    public function hasModel();
}
