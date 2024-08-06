<?php

namespace App\Http\Requests\Redirector;

use Illuminate\Foundation\Http\FormRequest;
use Mr1970\LaravelRedirector\Facades\Redirector;

class RedirectRequest extends FormRequest
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
        $rules = [
            'source_url' => 'required|url|unique:redirects',
            'destination_url' => 'required|url|different:source_url',
            'status_code' => 'required|integer|between:300,399',
            'is_active' => 'required|boolean',
        ];

        if (strtolower($this->method()) === 'put') {
            $rules['source_url'] .= ',source_url,' . $this->route('redirect')->id;
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'source_url' => __('source_url'),
            'destination_url' => __('destination_url'),
            'status_code' => __('status_code'),
            'is_active' => __('is_active'),
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => (bool)$this->is_active,
            'source_url' => Redirector::sanitizeUrl($this->source_url),
            'destination_url' => Redirector::sanitizeUrl($this->destination_url),
        ]);
    }
}
