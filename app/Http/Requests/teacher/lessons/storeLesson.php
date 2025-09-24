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

    public function messages(): array
    {
        return [
            'title_lesson.required'  => 'يجب إدخال عنوان للحصة',
            'title_lesson.max'       => 'أقصي عدد أحرف لعنوان الحصة 255 حرف',
            'file_lesson.required'   => 'يجب رفع الملف الخاص بالحصة',
            'file_lesson.mimes'      => 'الملفات المسموح رفعها : pdf,doc,docx,zip,rar,jpg,png',
            'file_lesson.file'       => 'الملف الخاص بك غير مناسب',
            'file_lesson.max'        => 'أقصي ملف يمكن رفعه 10 MB',
        ];
    }
}
