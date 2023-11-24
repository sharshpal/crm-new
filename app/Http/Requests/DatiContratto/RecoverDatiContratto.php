<?php

namespace App\Http\Requests\DatiContratto;

use App\Models\Esito;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class RecoverDatiContratto extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if (Auth::user()->hasRole("Admin")) return true;

        $isValid = Gate::allows('dati-contratto.set-recovered');
        $sanitized = $this->getSanitized();
        $dc = $this->datiContratto;

        $aC = Auth::user()->hasAssignedCampaigns();
        $aP = Auth::user()->hasAssignedPartners();

        if (($aC || (!$aC && !$aP)) && isset($sanitized["campagna"])) {
            $isValid &= Auth::user()->hasCampaign($sanitized["campagna"]);
        }
        if (($aP || (!$aC && !$aP)) && isset($sanitized["partner"])) {
            $isValid &= Auth::user()->hasPartner($sanitized["partner"]);
        }

        $isValid &= $dc->esito()->first()->is_final;
        $isValid &= !$dc->esito()->first()->is_ok;

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
            "recall_at" => ["nullable", "string"],
            "note_sv" => ["nullable", "string"]
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

        if (isset($sanitized["errors"])) {
            return [];
        }

        if(!empty($sanitized["note_sv"]) && !empty($this->datiContratto->note_sv)){
            $sanitized["note_sv"] = $this->datiContratto->note_sv . "\n\n" . $sanitized["note_sv"];
        }

        $sanitized["update_user"] = Auth::user()->id;
        $sanitized["recover_at"] =  Carbon::now();

        $e = Esito::where("is_recover", true)->first();
        if ($e) {
            $sanitized["esito"] = $e->id;
        }

        return $sanitized;
    }
}
