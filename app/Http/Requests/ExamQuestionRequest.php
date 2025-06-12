<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
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
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'options' => 'required|array|min:2',
            'options.A' => 'required_with:options|string',
            'options.B' => 'required_with:options|string',
            'options.C' => 'required_with:options|string',
            'options.D' => 'required_with:options|string',
        ];

            if ($this->isMethod('post')) {
                $rules['image'] = 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048';
            } else {
                $rules['image'] = 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048';
            }

        // Jawaban benar (untuk tipe benar_salah)
        if ($examTitle && $examTitle->exam_type === 'benar_salah') {
            $rules['correct_answer'] = [
                'required',
                Rule::in(array_keys((array) $this->input('options', [])))
            ];
        }

        // Poin per jawaban (untuk tipe poin)
        if ($examTitle && $examTitle->exam_type === 'poin') {
            $rules['points'] = [
                'required',
                'array',
                Rule::requiredIf(fn () => $examTitle->exam_type === 'poin'),
            ];

            $rules['points.A'] = 'required|integer|min:0';
            $rules['points.B'] = 'required|integer|min:0';
            $rules['points.C'] = 'required|integer|min:0';
            $rules['points.D'] = 'required|integer|min:0';
        }

        return $rules;
    }
}
