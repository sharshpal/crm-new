<?php

namespace App\Http\Requests\Admin\UserTimelog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateUserTimelog extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('admin.user-timelog.edit', $this->userTimelog);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'ore' => ['sometimes', 'numeric'],
            'minuti' => ['nullable', 'integer'],
            'user' => ['sometimes', 'array'],
            'campagna' => ['nullable', 'integer'],
            'period' => ['sometimes', 'date'],

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

        if (!empty($sanitized["user"]["id"])) {
            $sanitized["user"] = $sanitized["user"]["id"];
        }

        if(empty($sanitized["minuti"])){
            $sanitized["minuti"] = 0;
        }

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
