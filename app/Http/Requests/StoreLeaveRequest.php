<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveRequest extends FormRequest
{
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
            'start_date'=>'required|date',
            'end_date'=>'required|date|after:start_date',
            'personnel_id'=>'required|exists:personnels,id',
            'leave_type_id'=>'required|exists:leavetypes,id',
        ];
    }
}
