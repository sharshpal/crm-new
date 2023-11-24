<?php

namespace App\Http\Requests\Admin\Campagna;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreCampagna extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.campaign.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string','unique:campagna,nome,NULL,id,deleted_at,NULL'],
            'tipo' => ['required', 'array'],
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
        if(!empty($sanitized["tipo"]["id"])){
            $sanitized["tipo"] = $sanitized["tipo"]["id"];
        }

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
