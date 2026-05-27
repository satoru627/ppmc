<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminChariowSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    /**
     * Normalise la reference avant la validation d'unicite.
     */
    protected function prepareForValidation(): void
    {
        $reference = trim((string) $this->input('chariow_reference'));

        if ($reference !== '') {
            $reference = str_starts_with(strtoupper($reference), 'CHW-')
                ? 'CHW-' . substr($reference, 4)
                : 'CHW-' . $reference;
        }

        $this->merge([
            'customer_email' => strtolower(trim((string) $this->input('customer_email'))),
            'chariow_reference' => $reference,
        ]);
    }

    /**
     * Regles pour enregistrer une vente Chariow confirmee.
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:30'],
            'amount' => ['required', 'integer', 'min:1'],
            'chariow_reference' => [
                'required',
                'string',
                'max:120',
                Rule::unique('orders', 'payment_reference'),
            ],
        ];
    }
}
