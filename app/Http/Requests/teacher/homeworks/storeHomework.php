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

    public function messages(): array
    {
        return [
            'content_homework.required'    =>  'يجب إدخال المطلوب من الواجب',
            'content_homework.max'         =>  'أقصي عدد أحرف للمطلوب من الواجب 255 حرف',
            'title_homework.required'      =>  'يجب إدخال عنوان للواجب',
            'title_homework.max'           =>  'أقصي عدد أحرف لعنوان الواجب 255 حرف',
            'file_homework.required'       =>  'يجب رفع ملف الواجب',
            'file_homework.file'           =>  'الملف الخاص بالواجب غيرمناسب',
            'file_homework.mimes'          =>  'الملفات المسموح رفعها : pdf,doc,docx,zip,rar,jpg,png',
            'file_homework.max'            =>  'أقصي ملف يمكن رفعه 10 MB',
            'deadline_homework.required'   =>  'يجب إدخال وقت للديدلاين',
            'deadline_homework.date'       =>  'غير مسموح غير بادخال قيمه للوقت',
            'homework_mark.required'       =>  'يجب إدخال درجة الواجب',
            'homework_mark.min'            =>  'غير مسموح بالأرقام السالبة',
        ];
    }
}
