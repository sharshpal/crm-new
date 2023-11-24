<?php


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class CrmRequest extends FormRequest
{
    public function isAdminRequest()
    {
        return $this->route()->named('admin/*');
    }
}
