<?php

namespace App\Domains\Estate\Http\Requests;

use App\Domains\Common\Traits\Request\WithSorting;
use Illuminate\Foundation\Http\FormRequest;

class EstateItemsRequest extends FormRequest
{
    use WithSorting;

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            ...$this->sortingRules(),
        ];
    }
}
