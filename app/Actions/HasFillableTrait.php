<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Model;

trait HasFillableTrait 
{
    /**
     * @var array
     */
    protected $fillableValues = [];   

    /**
     * Set fillable values
     *
     * @param array $fillableValues
     * @return static
     */
    public function setFillableValues(array $fillableValues) 
    {
        $this->fillableValues = array_merge($this->fillableValues, $fillableValues);
        
        if ($this instanceof HasModel && $this->hasModel()) {
            $this->getModel()->fill($this->fillableValues);
        }

        return $this;
    }

    /**
     * Fill model using the values set in $fillableValues 
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function fill(Model $model) 
    {
        $model->fill($this->fillableValues);
        $model->save();
    }
}
