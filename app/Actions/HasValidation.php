<?php

namespace App\Actions;

interface HasValidation
{
    /**
     * Validate the action before executing.
     * 
     * @return void
     * 
     * @throws \App\Validation\ValidationException
     */
    public function validate();
}
