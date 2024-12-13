<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Services\LogService;

class UpdateUserTeacherRequest extends FormRequest
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
            'id' => 'required|integer',
            'name_id' => 'nullable|string|max:255',
            'user_name' => 'nullable|string|max:255',
            'address' => 'nullable|max:255',
            'phone' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|max:255',
            'yob' => 'nullable|date',
            'year_old' => 'nullable|integer',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $this->logService->warning('Update teacher:', $errors->messages());
    }
}
