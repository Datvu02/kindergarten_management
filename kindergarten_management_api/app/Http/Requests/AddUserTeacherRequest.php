<?php

namespace App\Http\Requests;

use App\Enums\RoleEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\Validation\Validator;
use App\Services\LogService;
use Illuminate\Foundation\Http\FormRequest;

class AddUserTeacherRequest extends FormRequest
{
    protected $logService;

    public function __construct(
        LogService $logService
    ) {
        $this->logService = $logService;
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_id' => 'required|max:255',
            'user_name' => 'required|max:255',
            'phone' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'yob' => 'nullable|date',
            'authority' => ['required', new Enum(RoleEnum::class)],
            'year_old' => 'nullable|integer',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $this->logService->warning('Add teacher:', $errors->messages());
    }
}
