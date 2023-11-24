<?php

namespace App\Http\Requests\Admin\SysSetting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreSysSetting extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.sys-setting.create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $_req = $this->request;

        return [
            'crm_user' => ['nullable',  Rule::unique('sys_settings', 'crm_user')->where('key', $_req->get("key")),'integer'],
            'key' => ['sometimes', Rule::unique('sys_settings', 'key')->where('crm_user', $_req->get("crm_user")), 'array'],
            'value' => ['required', 'array'],

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

        if (!empty($sanitized["crm_user"]["id"])) {
            $sanitized["crm_user"] = $sanitized["crm_user"]["id"];
        }


        if (!empty($sanitized["key"]["id"])) {
            $sanitized["key"] = $sanitized["key"]["id"];
        }


        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
