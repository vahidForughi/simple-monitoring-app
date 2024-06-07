<?php

namespace App\Http\Requests\Monitor;


use App\Rules\HttpStatusCodeRule;

class ShowRequest extends FetchRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'status_code' => [
                'nullable',
                new HttpStatusCodeRule(),
            ],
            'start_date' => [
                'nullable',
                'date',
                'date_format:Y-m-d H:i:s',
            ],
            'end_date' => [
                'nullable',
                'date',
                'date_format:Y-m-d H:i:s',
            ]
        ];
    }
}
