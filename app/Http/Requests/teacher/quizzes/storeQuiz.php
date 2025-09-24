<?php

namespace App\Http\Requests\teacher\quizzes;

use Illuminate\Foundation\Http\FormRequest;

class storeQuiz extends FormRequest
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
            'quiz_title'        => 'required|string|max:255',
            'quiz_date'         => 'required|date',
            'quiz_duration'     => 'required|integer|min:1',
            'question_title'    => 'required|array|max:255',
            'question_title.*'  => 'required|string',
            'option_title'      => 'required|array|max:255',
            'option_title.*'    => 'required|string',
            'correct_option'    => 'required|array',
            'correct_option.*'  => 'required|in:الإجابة 4,الإجابة 3,الإجابة 2,الإجابة 1',
            'question_mark'     => 'required|array',
            'question_mark.*'   => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'quiz_title.required'         => 'يجب إدخال عنوان للإمتحان',
            'quiz_title.max'              => 'أقصي عدد أحرف لعنوان الإمتحان 255 حرف',
            'quiz_date.required'          => 'يجب إدخال تاريخ الإمتحان',
            'quiz_duration.required'      => 'يجب إدخال مدة الإمتحان',
            'quiz_duration.min'           => 'أقل مدة يمكن ادخالها دقيقة واحدة',
            'question_title.*.required'   => 'يجب إدخال نص السؤال ',
            'question_title.*.max'        => 'أقصي عدد أحرف لنص السؤال 255 حرف',
            'option_title.*.required'     => 'يجب إدخال نص للإختيارات ',
            'option_title.*.max'          => 'أقصي عدد أحرف لنص الإختيارات 255 حرف',
            'correct_option.*.required'   => 'يجب إختيار الإجابة الصحيحة للسؤال',
            'correct_option.*.in'         => 'الإجابة الصحيحة من هذه الإختيارات [الإجابة 4,الإجابة 3,الإجابة 2,الإجابة 1]',
            'question_mark.*.required'    => 'يجب إدخال درجة كل سؤال',
            'question_mark.*.min'         => 'غير مسموح بالأرقام السالبة',
        ];
    }
}
