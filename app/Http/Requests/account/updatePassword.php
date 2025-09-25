<?php

namespace App\Http\Requests\account;

use Illuminate\Foundation\Http\FormRequest;

class updatePassword extends FormRequest
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
            'email'             => 'required | email|exists:users,email',
            'NewPassword'       => 'required | min:8',
            'ConfirmPassword'   => 'required | same:NewPassword',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'            => 'يجب إدخال الإيميل الخاص بك',
            'email.email'               => 'صيغة الإيميل غير صحيحه',
            'email.exists'              => 'هذا الإيميل غير موجود !',
            'NewPassword.required'      => 'يجب إدخال كلمة المرور الجديدة',
            'NewPassword.min'           => 'يجب ألا يقل كلمة المرور عن 8 أحرف',
            'ConfirmPassword.required'  => 'يجب إدخال كلمة المرور الجديدة للتأكيد',
            'ConfirmPassword.same'      => 'لا يوجد تطابق لكلمة المرور الجديدة',
        ];
    }
}
