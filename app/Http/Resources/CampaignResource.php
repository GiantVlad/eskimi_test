<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Services\MathService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        $mathService = app()->get(MathService::class);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'from' => $this->date_from,
            'to' => $this->date_to,
            'daily_budget' => $mathService->intToFloatString((int)$this->daily_budget),
            'total_budget' => $mathService->intToFloatString((int)$this->total_budget),
            'images' => BannerResource::collection($this->whenLoaded('banners')),
        ];
    }
}
