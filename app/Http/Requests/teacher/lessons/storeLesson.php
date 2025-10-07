<?php

namespace App\Http\Requests\teacher\lessons;

use Illuminate\Foundation\Http\FormRequest;

class storeLesson extends FormRequest
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
            'title_lesson'  => 'required|string|max:255',
            'file_lesson'   => 'required|file|mimes:pdf,doc,docx,zip,rar,jpg,png|max:10240',
        ];
    }
}
