<?php

namespace App\Burger\Models;

use Illuminate\Database\Eloquent\Model;

class Burger extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'burgers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_name', 'components'
    ];
}
