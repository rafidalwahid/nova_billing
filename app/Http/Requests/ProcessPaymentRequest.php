<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProcessPaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && ($this->user()->isAdmin() || $this->user()->isCustomer());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'invoice_id' => ['required', 'exists:invoices,id'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:999999.99'],
            'payment_method' => ['required', 'in:credit_card,bank_transfer,paypal,stripe,check'],
            'payment_gateway' => ['nullable', 'string', 'in:stripe,paypal,authorize_net'],
            'currency' => ['required', 'string', 'size:3', 'in:USD,CAD,GBP,EUR,AUD'],

            // Credit card fields (when payment_method is credit_card)
            'card_number' => [
                Rule::requiredIf($this->payment_method === 'credit_card'),
                'nullable',
                'string',
                'regex:/^[0-9]{13,19}$/'
            ],
            'card_expiry_month' => [
                Rule::requiredIf($this->payment_method === 'credit_card'),
                'nullable',
                'integer',
                'between:1,12'
            ],
            'card_expiry_year' => [
                Rule::requiredIf($this->payment_method === 'credit_card'),
                'nullable',
                'integer',
                'min:' . date('Y'),
                'max:' . (date('Y') + 20)
            ],
            'card_cvv' => [
                Rule::requiredIf($this->payment_method === 'credit_card'),
                'nullable',
                'string',
                'regex:/^[0-9]{3,4}$/'
            ],
            'cardholder_name' => [
                Rule::requiredIf($this->payment_method === 'credit_card'),
                'nullable',
                'string',
                'max:255'
            ],

            // Bank transfer fields
            'bank_account_number' => [
                Rule::requiredIf($this->payment_method === 'bank_transfer'),
                'nullable',
                'string',
                'max:50'
            ],
            'bank_routing_number' => [
                Rule::requiredIf($this->payment_method === 'bank_transfer'),
                'nullable',
                'string',
                'max:20'
            ],

            // Reference information
            'reference_number' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'amount.min' => 'Payment amount must be at least $0.01.',
            'amount.max' => 'Payment amount cannot exceed $999,999.99.',
            'card_number.regex' => 'Please enter a valid credit card number.',
            'card_cvv.regex' => 'Please enter a valid CVV code.',
            'card_expiry_year.min' => 'Card expiry year cannot be in the past.',
            'invoice_id.exists' => 'The selected invoice does not exist.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Remove spaces and dashes from card number
        if ($this->has('card_number')) {
            $this->merge([
                'card_number' => preg_replace('/[\s\-]/', '', $this->card_number),
            ]);
        }

        // Ensure amount is properly formatted
        if ($this->has('amount')) {
            $this->merge([
                'amount' => number_format((float)$this->amount, 2, '.', ''),
            ]);
        }
    }
}
