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
            // Name Fields
            'first_name' => ['required', 'string', 'max:255'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'grandfather_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            
            // Email Validation
            'email' => [
                'required',
                'string',
                'lowercase',  // Ensure email is in lowercase
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->user_id, 'user_id'), // Ignore the current user's email
            ],

            // Gender & Other Personal Info
            'gender' => ['nullable', 'in:male,female'],
            'date_of_birth' => ['nullable', 'date'],
            'nationality' => ['nullable', 'string', 'max:255'],
            'id_number' => ['nullable', 'string', 'max:255'],
            'marital_status' => ['nullable', 'in:single,married'],
            'phone' => ['nullable', 'string', 'max:255'],

            // Address Information
            'residence_place' => ['nullable', 'string', 'max:255'],
            'street_name' => ['nullable', 'string', 'max:255'],
            'building_number' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'ZIP' => ['nullable', 'string', 'max:255'],

            // Profile Photo (Optional)
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true; // Allow all users to make this request
    }
}
