<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarathonRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|min:3|max:255',
            'start' => 'required|min:3|max:255|date_format:Y-m-d H:i:s',
            'end' => 'required|min:3|max:255|date_format:Y-m-d H:i:s',
            'preview' => 'nullable|min:3|max:255',
            'description' => 'nullable'
        ];
    }
}
