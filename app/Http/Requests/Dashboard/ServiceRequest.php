<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where('status', 1),
            ],
            'api_id' => [
                'required',
                Rule::exists('apis', 'id'),
            ],
            'type_id' => [
                'required',
                Rule::exists('types', 'id'),
            ],
            'api_service' => 'required|int',
            'name' => 'required|max:191',
            'description' => 'required',
            'quantity_min' => 'required|numeric|min:1',
            'quantity_max' => 'required|numeric|min:1',
            'price' => 'required|numeric',
            'refill' => 'in:1',
        ];
    }
}
