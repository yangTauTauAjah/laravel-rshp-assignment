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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('user', 'email')->ignore($this->user()->iduser, 'iduser'),
            ],
        ];
    }

    /**
     * Get the validated data from the request with proper field mapping.
     *
     * @return array<string, mixed>
     */
    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated($key, $default);
        
        // Map 'name' to 'nama' for our User model
        if (isset($validated['name'])) {
            $validated['nama'] = $validated['name'];
            unset($validated['name']);
        }
        
        return $validated;
    }
}
