<?php

namespace App\Http\Requests\DatiContratto;

use App\Http\Requests\CrmRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ApiCreateDatiContratto extends CrmRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if(Auth::user()->hasRole("Admin")) return true;

        $isValid = Gate::allows('dati-contratto.apicreate');


        return $isValid;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'phone_number' => ['required','string'],
            'alt_phone' => ['nullable','string'],
            'comments' => ['nullable','string'],
            'campaign' => ['nullable','string'],
            'fullname' => ['required','string']
        ];
    }

    public function getSanitized(): array
    {
        $sanitized = $this->validated();
        return $sanitized;
    }
}
