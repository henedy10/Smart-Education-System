<?php

namespace App\Http\Requests\account;

use Illuminate\Foundation\Http\FormRequest;

class login extends FormRequest
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
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => ' يجب إدخال الإيميل الخاص بك',
            'email.email'       => 'صيغة الإيميل غير صحيحه',
            'email.exists'      => 'هذا الإيميل غير موجود!',
            'password.required' => 'يجب إدخال كلمة المرور الخاصة بك',
            'password.min'      => 'يجب ألا تقل كلمة المرور عن 8 أحرف',
        ];
    }
}
