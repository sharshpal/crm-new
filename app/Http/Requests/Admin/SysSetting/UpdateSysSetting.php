<?php

namespace App\Http\Requests\Admin\SysSetting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateSysSetting extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.sys-setting.edit', $this->sysSetting);
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
            'crm_user' => ['nullable', Rule::unique('sys_settings', 'crm_user')->where('key', $_req->get("key"))->ignore($this->sysSetting->getKey()),'integer'],
            'key' => ['required', Rule::unique('sys_settings', 'key')
                                    ->where(function($query) use ($_req) {
                                        if($_req->get("crm_user")){
                                            $query->where('sys_settings.crm_user',$_req->get("crm_user"));
                                        }
                                        else{
                                            $query->whereNull("sys_settings.crm_user");
                                        }
                                        $query->where("sys_settings.id","<>",$this->sysSetting->getKey());
                                        return $query;
                                    })
                                    ->ignore($this->sysSetting->getKey())
                , 'array'],
            'value' => ['sometimes', 'array'],
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
