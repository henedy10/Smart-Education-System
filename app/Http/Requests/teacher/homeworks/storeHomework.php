<?php

namespace App\Http\Requests\teacher\homeworks;

use Illuminate\Foundation\Http\FormRequest;

class storeHomework extends FormRequest
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
            'content_homework'   => 'required|string|max:255',
            'title_homework'     => 'required|string|max:255',
            'file_homework'      => 'required|file|mimes:pdf,doc,docx,zip,rar,jpg,png|max:10240',
            'deadline_homework'  => 'required|date',
            'homework_mark'      => 'required|integer|min:0',
        ];
    }
}
