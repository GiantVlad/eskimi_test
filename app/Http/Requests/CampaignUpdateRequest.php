<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\ImageTypes;
use Illuminate\Foundation\Http\FormRequest;

class CampaignUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:campaigns',
            'name' => 'required|min:2|max:300|unique:campaigns,name,' . $this->get('id'),
            'daily_budget' => 'required|numeric|min:0.1|max:999999',
            'total_budget' => 'required|numeric|min:0.1|max:9999999',
            'from' => 'required|date',
            'to' => 'required|date|after:from',
            'pictures.*' => 'image|mimes:' . implode(',', ImageTypes::IMAGE_TYPES),
            'imagesToRemove.*' => 'exists:banners,id',
        ];
    }
}
