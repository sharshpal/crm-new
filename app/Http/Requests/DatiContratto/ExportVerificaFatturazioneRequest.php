<?php

namespace App\Http\Requests\DatiContratto;

use App\Http\Requests\CrmRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ExportVerificaFatturazioneRequest extends CrmRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {

        if(Auth::user()->hasRole("Admin")) return true;

        $isValid = Gate::allows('check.invito-fatturazione');

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
            'verifyData' => ['required','array'],

            'verifyData.*.row' => ["required",'integer'],
            'verifyData.*.cf' => ["nullable",'string'],
            'verifyData.*.pod' => ["nullable",'string'],
            'verifyData.*.pdr' => ["nullable",'string'],
            //'verifyData.*.pod' => "nullable|required_if:verifyData.*.pdr,=,null",
            //'verifyData.*.pdr' => "nullable|required_if:verifyData.*.pod,=,null",
            'verifyData.*.campagna' => ["nullable",'integer'],
            'verifyData.*.cod_pr' => ["nullable","string"],
            'verifyData.*.note' => ["nullable","string"],
            'verifyData.*.stato' => ["nullable","integer"],
        ];
    }


    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {
        $sanitized = $this->validate($this->rules());

        return $sanitized;
    }
}
