<?php

namespace App\Http\Requests;

use App\Services\LogService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class AddClassRequest extends FormRequest
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
            'class_name'=> 'required|max:255',
            'homeroom_teacher_id' => 'nullable|integer',
        ];
    }
    
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        $this->logService->warning('Add class:', $errors->messages());
    }
}
