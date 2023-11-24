<?php

namespace App\Http\Requests\Admin\Esito;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DestroyEsito extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $canBeDeleted = !$this->esito->is_recover && !$this->esito->is_new;
        return Gate::allows('admin.esito.delete', $this->esito) && $canBeDeleted;
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
