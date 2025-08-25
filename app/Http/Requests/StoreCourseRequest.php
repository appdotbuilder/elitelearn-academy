<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->hasRole('instructor');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|unique:courses,title',
            'short_description' => 'required|string|max:500',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'level' => 'required|in:beginner,intermediate,advanced',
            'price' => 'required|numeric|min:0|max:9999.99',
            'is_free' => 'required|boolean',
            'requirements' => 'nullable|array',
            'requirements.*' => 'string|max:255',
            'what_you_will_learn' => 'nullable|array',
            'what_you_will_learn.*' => 'string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'language' => 'required|string|max:10',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Course title is required.',
            'title.unique' => 'A course with this title already exists.',
            'short_description.required' => 'Short description is required.',
            'description.required' => 'Course description is required.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'Selected category is invalid.',
            'level.required' => 'Please select a difficulty level.',
            'price.required' => 'Course price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'is_free.required' => 'Please specify if the course is free or paid.',
        ];
    }
}