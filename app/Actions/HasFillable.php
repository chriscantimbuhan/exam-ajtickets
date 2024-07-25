<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;

interface HasFillable
{
    /**
     * Set fillable values
     *
     * @param array $fillableValues
     * @return static
     */
    public function setFillableValues(array $fillableValues);

    /**
     * Fill model using the values set in $fillableValues 
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function fill(Model $model);
}