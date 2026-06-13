<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArchiveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('document_date')) {
            $date = $this->input('document_date');

            if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $date, $matches)) {
                $this->merge([
                    'document_date' => sprintf('%04d-%02d-%02d', $matches[3], $matches[2], $matches[1]),
                ]);
            }
        }
    }

    public function rules(): array
    {
        $rules = [
            'category_id' => ['required', 'exists:categories,id'],
            'document_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('archives')->ignore($this->route('archive')),
            ],
            'title' => ['required', 'string', 'max:255'],
            'document_date' => ['required', 'date'],
            'description' => ['nullable', 'string'],
        ];

        if ($this->isMethod('POST')) {
            $rules['file'] = ['required', 'mimes:pdf', 'max:10240'];
        } else {
            $rules['file'] = ['nullable', 'mimes:pdf', 'max:10240'];
        }

        return $rules;
    }
}
