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
        // Only allow customers to create tickets
        return $this->user() && $this->user()->isCustomer();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'priority' => [
                'sometimes',
                'required',
                Rule::in(['low', 'normal', 'high', 'urgent'])
            ],
            'category' => [
                'sometimes',
                'required',
                Rule::in(['billing', 'technical', 'sales', 'general'])
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'subject.required' => 'Subject is required.',
            'subject.max' => 'Subject cannot exceed 255 characters.',
            'description.required' => 'Description is required.',
            'description.min' => 'Description must be at least 10 characters.',
            'priority.in' => 'Priority must be one of: low, normal, high, urgent.',
            'category.in' => 'Category must be one of: billing, technical, sales, general.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'subject' => 'ticket subject',
            'description' => 'ticket description',
        ];
    }
}
