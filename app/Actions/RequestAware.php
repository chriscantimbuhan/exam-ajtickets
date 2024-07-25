<?php

namespace App\Actions;

use Illuminate\Http\Request;

interface RequestAware
{
    /**
     * Set the request object.
     * 
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function setRequest(Request $request);
}