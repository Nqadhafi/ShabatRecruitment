<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $examTitle = $this->route('examTitle');

        $rules = [
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
        ];

        if ($examTitle && $examTitle->exam_type === 'benar_salah') {
            $rules['correct_answer'] = 'required|in:A,B,C,D';
        } elseif ($examTitle && $examTitle->exam_type === 'poin') {
            $rules['point_a'] = 'required|integer|min:0';
            $rules['point_b'] = 'required|integer|min:0';
            $rules['point_c'] = 'required|integer|min:0';
            $rules['point_d'] = 'required|integer|min:0';
        }

        return $rules;
    }
}
