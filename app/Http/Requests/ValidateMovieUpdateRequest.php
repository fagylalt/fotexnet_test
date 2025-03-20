<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateMovieUpdateRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string|min:10',
            'age_limit' => 'sometimes|required|integer|min:0|max:18',
            'language' => 'sometimes|required|string',
            'cover_art' => 'sometimes|required|string',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge($this->all());
    }
}
