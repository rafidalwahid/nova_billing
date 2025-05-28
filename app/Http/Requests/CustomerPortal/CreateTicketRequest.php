<?php

namespace App\Http\Requests\CustomerPortal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only customers can create tickets through this endpoint
        return $this->user() && $this->user()->isCustomer();
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'department' => [
                'required',
                'string',
                Rule::in(['billing', 'technical', 'general', 'sales'])
            ],
            'priority' => [
                'required',
                'string',
                Rule::in(['low', 'medium', 'high'])
            ],
            'subject' => [
                'required',
                'string',
                'min:5',
                'max:100'
            ],
            'description' => [
                'required',
                'string',
                'min:20',
                'max:1000'
            ],
            'email' => [
                'required',
                'email',
                'max:254'
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'department.required' => 'Please select a department.',
            'department.in' => 'Please select a valid department.',
            'priority.required' => 'Please select a priority level.',
            'priority.in' => 'Please select a valid priority level.',
            'subject.required' => 'Please provide a subject for your ticket.',
            'subject.min' => 'Subject must be at least 5 characters long.',
            'subject.max' => 'Subject cannot exceed 100 characters.',
            'description.required' => 'Please provide a description of your issue.',
            'description.min' => 'Description must be at least 20 characters long.',
            'description.max' => 'Description cannot exceed 1000 characters.',
            'email.required' => 'Please provide a contact email address.',
            'email.email' => 'Please provide a valid email address.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'department' => 'department',
            'priority' => 'priority level',
            'subject' => 'subject',
            'description' => 'description',
            'email' => 'email address'
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'subject' => trim($this->subject ?? ''),
            'description' => trim($this->description ?? ''),
            'email' => trim(strtolower($this->email ?? ''))
        ]);
    }
}
