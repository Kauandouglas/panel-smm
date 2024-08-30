<?php

namespace App\Http\Requests\Panel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AccountRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:191',
            'image' => 'nullable|image|max:3000',
            'phone' => (!isset($this->request->all()['_method']) ? 'required|celular_com_ddd' : 'nullable'),
            'email' => 'required|email|max:191|unique:users,email,' . Auth::id(),
            'password' => (!isset($this->request->all()['_method']) ? 'required|min:5' : 'nullable|confirmed|min:5'),
        ];
    }
}
