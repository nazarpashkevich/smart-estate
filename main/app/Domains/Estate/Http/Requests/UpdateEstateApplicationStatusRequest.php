<?php

namespace App\Domains\Estate\Http\Requests;

use App\Domains\Estate\Enums\EstateApplicationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateEstateApplicationStatusRequest extends FormRequest
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
            'status' => ['required', new Enum(EstateApplicationStatus::class)],
        ];
    }

    public function status(): EstateApplicationStatus
    {
        return $this->enum('status', EstateApplicationStatus::class);
    }
}
