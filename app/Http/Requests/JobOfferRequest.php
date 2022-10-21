<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobOfferRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:50',
            // exists:テーブル名,カラム名でカラムに値がの存在するか確認
            'occupation_id' => 'required|exists:occupations,id',
            'due_date' => 'required|after_or_equal:today',
            'description' => 'required|string|max:2000',
            'status' => 'nullable|boolean',
        ];

        // ルートを取得、処理によってバリデーションを変更する
        $route = $this->route()->getName();

        $rule = [
            'title' => 'required|string|max:50',
            // exists:テーブル名,カラム名でカラムに値がの存在するか確認
            'occupation_id' => 'required|exists:occupations,id',
            'due_date' => 'required|after_or_equal:today',
            'description' => 'required|string|max:2000',
            'is_published' => 'nullable|boolean',
        ];

        if ($route === 'job_offer.update') {
            $rule['due_date'] = 'required|date';
        }

        return $rule;
    }
}
