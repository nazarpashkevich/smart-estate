<?php

namespace App\Domains\Estate\Http\Requests;

use App\Domains\Estate\Data\EstateApplicationData;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

class EstateApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name'           => ['string', 'required'],
            'phone'          => ['string', 'required'],
            'suggestedPrice' => ['numeric', 'min:1', 'required'],
            'estateItemId'   => ['numeric', 'required', new Exists('estate_items', 'id')],
        ];
    }

    public function toData(): EstateApplicationData
    {
        return EstateApplicationData::from($this->all());
    }
}
