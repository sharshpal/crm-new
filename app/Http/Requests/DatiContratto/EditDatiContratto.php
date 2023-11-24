<?php

namespace App\Http\Requests\DatiContratto;

use App\Http\Requests\CrmRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EditDatiContratto extends CrmRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if(Auth::user()->hasRole("Admin")) return true;

        $isValid = Gate::allows('dati-contratto.edit');
        $dc = $this->datiContratto;

        $aC = Auth::user()->hasAssignedCampaigns();
        $aP = Auth::user()->hasAssignedPartners();

        if(($aC || (!$aC && !$aP)) && $dc->campagna){
            $isValid &= Auth::user()->hasCampaign($dc->campagna);
        }
        if(($aP || (!$aC && !$aP)) && $dc->partner){
            $isValid &= Auth::user()->hasPartner($dc->partner);
        }

        $isValid &= ((!$dc->esito()->first()->is_final) || Gate::allows('dati-contratto.edit-when-closed'));

        return $isValid;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
