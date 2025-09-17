<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string|max:255',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password'  => 'required|string|min:6'
        ];
    }
}
