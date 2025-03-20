<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ValidateScreeningCreationRequest extends FormRequest
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
            'date' => 'required|date',
            'available_seats' => 'required|int|max:50',
            'movie_id' => 'required|integer|exists:movies,id',
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
            'date.required' => 'A date is required for the screening.',
            'date.date' => 'The date must be a valid date.',
            'available_seats.required' => 'Please provide the maximum seating number for the movie.',
            'available_seats.max' => 'The available seats must not exceed 50.',
            'movie_id.required' => 'Movie id is required.',
            'movie_id.integer' => 'Movie id must be a number.',
            'movie_id.exists' => 'The movie must exist.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException($validator, response()->json([
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422));
    }
}
