<?php

namespace App\Http\Requests\Admin\Partner;

use App\Http\Requests\CrmRequest;
use Illuminate\Support\Facades\Gate;

class IndexPartner extends CrmRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return
            Gate::allows('admin.partner.index')
            || Gate::allows('partner.index');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'orderBy' => 'in:id,nome|nullable',
            'orderDirection' => 'in:asc,desc|nullable',
            'search' => 'string|nullable',
            'page' => 'integer|nullable',
            'per_page' => 'integer|nullable',

        ];
    }
}
