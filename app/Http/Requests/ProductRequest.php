<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return (bool) $this->user()?->isAdmin();
    }

    /**
     * Regles de creation et modification des formations/services.
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'type' => ['required', Rule::in(['formation', 'service'])],
            'price' => ['required', 'integer', 'min:500'],
            'chariow_checkout_url' => ['nullable', 'string', 'max:2048', 'url', 'starts_with:https://'],
            'product_file' => ['nullable', 'file', 'max:51200', 'mimes:pdf,zip,mp4,mov,doc,docx,ppt,pptx,xls,xlsx,txt'],
            'image' => ['nullable', 'image', 'max:5120', 'mimes:jpg,jpeg,png,webp,avif'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
