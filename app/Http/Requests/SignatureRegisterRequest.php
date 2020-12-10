<?php

namespace App\Http\Requests;

use App\Rules\RecaptchaRule;
use Illuminate\Foundation\Http\FormRequest;

class SignatureRegisterRequest extends FormRequest
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
            'g-recaptcha-response' => ['required', new RecaptchaRule()],
            'first_name' => ['required', 'max:150'],
            'last_name' => ['max:150'],
            'occupation_name' => ['max:150'],
            'signature' => ['required'],
            'content' => ['max:3000'],
        ];
    }
}
