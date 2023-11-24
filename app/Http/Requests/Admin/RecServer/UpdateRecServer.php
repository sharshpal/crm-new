<?php

namespace App\Http\Requests\Admin\RecServer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateRecServer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.rec-server.edit', $this->recServer);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string'],
            'type' => ['sometimes', 'string'],
            'db_driver' => ['required', 'string'],
            'db_host' => ['sometimes', 'string'],
            'db_port' => ['sometimes', 'string'],
            'db_name' => ['sometimes', 'string'],
            'db_user' => ['sometimes', 'string'],
            'db_password' => ['sometimes', 'string'],
            'db_rewrite_host' => ['sometimes', 'boolean'],
            'db_rewrite_search' => ['nullable', 'string'],
            'db_rewrite_replace' => ['nullable', 'string'],

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


        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
