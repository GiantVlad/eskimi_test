<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\ImageTypes;

class CampaignCreateRequest extends CampaignUpdateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:300|unique:campaigns,name',
            'daily_budget' => 'required|numeric|min:0.1|max:999999',
            'total_budget' => 'required|numeric|min:0.1|max:9999999',
            'from' => 'required|date',
            'to' => 'required|date|after:from',
            'pictures.*' => 'image|mimes:' . implode(',', ImageTypes::IMAGE_TYPES),
            'pictures' => 'required',
        ];
    }
}
