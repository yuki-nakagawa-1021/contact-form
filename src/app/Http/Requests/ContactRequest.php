<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:8'],
            'last_name' => ['required', 'string', 'max:8'],
            'gender' => ['required'],
            'email' => ['required',  'email'],
            'tel1' => ['required','numeric','digits_between:2,4'],
            'tel2' => ['required','numeric','digits_between:3,4'],
            'tel3' => ['required','numeric','digits_between:3,4'],
            'address' => ['required'],
            'category_id' => ['required'],
            'detail' => ['required', 'max:120'],
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => '姓を入力してください',
            'first_name.string' => '名前を文字列で入力してください',
            'first_name.max' => '名前を8文字以下で入力してください',
            'last_name.required' => '名を入力してください',
            'last_name.string' => '名前を文字列で入力してください',
            'last_name.max' => '名前を8文字以下で入力してください',
            'gender' => '性別を選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'tel1.required' => '電話番号を入力してください',
            'tel1.numeric' => '電話番号を半角数値で入力してください',
            'tel1.digits_between' => '電話番号は5桁まで数字で入力してください',
            'tel2.required' => '電話番号を入力してください',
            'tel2.numeric' => '電話番号を半角数値で入力してください',
            'tel2.digits_between' => '電話番号は5桁まで数字で入力してください',
            'tel3.required' => '電話番号を入力してください',
            'tel3.numeric' => '電話番号を半角数値で入力してください',
            'tel3.digits_between' => '電話番号は5桁まで数字で入力してください',
            'address.required' => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'detail.required' => 'お問い合わせ内容を入力してください',
            'detail.max' => 'お問い合わせ内容を120文字以下で入力してください',
        ];
    }
}
