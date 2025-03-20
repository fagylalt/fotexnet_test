<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ValidateMovieCreationRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'age_limit' => 'required|integer',
            'language' => 'required|string|max:25',
            'cover_art' => 'required|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'A title is required for the movie.',
            'title.max' => 'The title must not exceed 255 characters.',
            'description.required' => 'Please provide a description for the movie.',
            'description.max' => 'The description must not exceed 255 characters.',
            'age_limit.required' => 'Age limit is required.',
            'age_limit.integer' => 'Age limit must be a number.',
            'language.required' => 'The movie language is required.',
            'language.max' => 'The language must not exceed 25 characters.',
            'cover_art.required' => 'Please provide a cover art URL for the movie.',
            'cover_art.max' => 'The cover art URL must not exceed 255 characters.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}
