<?php

namespace App\Burger\Models;

use Illuminate\Database\Eloquent\Model;

class BurgerComponent extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'burger_components';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'countable'
    ];
}
