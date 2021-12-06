<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSettingRequest extends FormRequest
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
        return [
            'language' => 'sometimes|nullable',
            'currency' => 'sometimes|nullable',
            'default_tax' => 'sometimes|nullable',

            'company_name' => 'sometimes|required',
            'phone' => 'sometimes|required',
            'email' => 'sometimes|required',
            'address' => 'sometimes|required',
            'city' => 'sometimes|nullable',
            'company_logo' => 'sometimes|required|image|max:2048',

            'working_days' => 'sometimes|required|numeric|min:1',
            'working_hours' => 'sometimes|required|numeric|min:1',

            'number_prefix' => 'sometimes|nullable',
            'due_to_days' => 'sometimes|required',
            'notes' => 'sometimes|nullable',
            'footer' => 'sometimes|nullable',
            'color' => 'sometimes|nullable',
            'show_item_description' => 'sometimes|required',
            'show_logo' => 'sometimes|required',

        ];
    }
}
