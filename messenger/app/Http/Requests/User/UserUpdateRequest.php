<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !!((User::where('username', request()->route('username'))->firstOrFail())->user_id === auth()->id());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return User::rules([
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user->id)],
            'username' => ['required', 'min:4', Rule::unique('users', 'username')->ignore($this->user->id)],
        ]);
    }
}
