<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ExportSelected extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        // note character limit enforced on filename
        $rules['exportFilename'] = 'required|alpha_dash|max:80';
        $rules['studentId'] = 'required|array|min:1';

        $students = $this->request->get('studentId');

        if (is_array($students) && count($students) > 0) {
            foreach($this->request->get('studentId') as $key => $val) {
                $rules['studentId.'.$key] = 'integer';
            }
        }

        return $rules;
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
