<?php

namespace App\Http\Requests\DatiContratto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class EditEsitoContratto extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if(Auth::user()->hasRole("Admin")) return true;

        $isValid =  Gate::allows('dati-contratto.set-esito');
        $sanitized = $this->getSanitized();
        $dc = $this->datiContratto;

        $aC = Auth::user()->hasAssignedCampaigns();
        $aP = Auth::user()->hasAssignedPartners();

        if(($aC || (!$aC && !$aP)) && isset($sanitized["campagna"])){
            $isValid &= Auth::user()->hasCampaign($sanitized["campagna"]);
        }
        if(($aP || (!$aC && !$aP)) && isset($sanitized["partner"])){
            $isValid &= Auth::user()->hasPartner($sanitized["partner"]);
        }

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
            'esito' => ['required','integer']
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

        if(isset($sanitized["errors"])){
            return [];
        }

        $sanitized["update_user"] = Auth::user()->id;

        return $sanitized;
    }
}
