<?php

namespace App\Domains\Estate\Http\Requests;

use App\Domains\Common\Actions\SaveFileAction;
use App\Domains\Estate\Data\EstateItemData;
use App\Domains\Estate\Enums\EstateItemType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class EstateItemRequest extends FormRequest
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
            'preview'     => ['image', 'nullable'],
            'description' => ['string'],
            'rooms'       => ['integer', 'min:1'],
            'floor'       => ['integer', 'min:1'],
            'type'        => ['required', new Enum(EstateItemType::class)],
            'yearOfBuild' => ['integer', 'min:1960'],
            'square'      => ['numeric', 'min:1'],
            'bedrooms'    => ['integer', 'min:1'],
            'hasParking'  => ['boolean'],
            'lat'         => ['numeric', 'nullable'],
            'lng'         => ['numeric', 'nullable'],
            'price'       => ['numeric', 'min:1', 'required'],
            'features'    => ['array'],
        ];
    }

    public function toData(): EstateItemData
    {
        $preview = null;

        if ($this->hasFile('preview')) {
            $preview = app(SaveFileAction::class)->handle($this->file('preview'));
        }

        return EstateItemData::from([...$this->all(), 'preview' => $preview]);
    }
}
