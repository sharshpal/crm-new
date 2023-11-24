<?php

namespace App\Http\Requests\DatiContratto;

use App\Http\Requests\CrmRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ExportStatisticheEsiti extends CrmRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {

        if(Auth::user()->hasRole("Admin")) return true;

        $isValid = Gate::allows('dati-contratto.statistiche-esiti.export');

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
            'campagna' => ['nullable','array'],
            'partner' => ['nullable','array'],
            'crm_user' => ['nullable','array'],
            'fromDate' => ['nullable', 'string'],
            'toDate' => ['nullable', 'string'],
            'search' => ['nullable', 'string'],
            //'esito' => ['nullable', 'array'],
            //'tipo_offerta' => ['nullable', 'array'],
            //'tipo_inserimento' => ['nullable', 'array'],
            //'tipo_contratto' => ['nullable', 'array'],
            'groupByLabel' => ['nullable','string']
        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validated();

        return $sanitized;
    }
}
