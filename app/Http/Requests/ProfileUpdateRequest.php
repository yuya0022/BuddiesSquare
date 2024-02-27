<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            // 'bithday' は値を送信しないので、バリデーション不要
            // 'sex' は値を送信しないので、バリデーション不要
            'residence' => ['required', 'string', 'max:255'],
            'x_user_name' => ['nullable', 'string', 'min:4', 'max:16'],
            'status_message' => ['required', 'string', 'max:50'],
            'fan_career' => [],
            'members' => ['required'],
            'self-introduction' => ['required', 'string', 'max:1000'],
            'songs' => ['required'],
            'collection_of_eventinfo' => [],
            'answer_1' => ['nullable', 'string', 'max:1000'],
            'answer_2' => ['nullable', 'string', 'max:1000'],
            'answer_3' => ['nullable', 'string', 'max:1000'],
            'answer_4' => ['nullable', 'string', 'max:1000'],
            'answer_5' => ['nullable', 'string', 'max:1000'],
            'answer_6' => ['nullable', 'string', 'max:1000'],
        ];
    }
}