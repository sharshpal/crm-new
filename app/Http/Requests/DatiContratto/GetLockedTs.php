<?php

namespace App\Http\Requests\DatiContratto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class GetLockedTs extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
        //return Gate::allows('admin.user-timelog.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'fromDate' => 'required|date',
            'toDate' => 'required|date',
            'id' => 'nullable|integer'
        ];
    }
}
