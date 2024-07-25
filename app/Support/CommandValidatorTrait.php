<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait CommandValidatorTrait
{
    public function applyValidator(Request $request, $rules = null)
    {
        if (is_null($rules)) {
            $rules = $request->rules();
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->stopOnFirstFailure()->fails()) {
            return $this->formatErrors($validator->errors());
        }
    }

    protected function formatErrors($errors)
    {
        $formattedErrors = [];

        foreach (collect($errors) as $key => $error) {
            foreach ($error as $val) {
                $formattedErrors[] = $val;
            }
        }

        return implode("\n" , $formattedErrors);
    }

    public function fieldValidation(Request $request, $field)
    {
        return $this->applyValidator($request, [
            $field => $request->rules()[$field]
        ]);
    }
}
