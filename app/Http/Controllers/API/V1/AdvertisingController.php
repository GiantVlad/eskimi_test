<?php

declare(strict_types=1);

namespace App\Http\Controllers\API\V1;

use App\DTO\CampaignRequestDTO;
use App\Exceptions\ImageUploadException;
use App\Http\Requests\CampaignCreateRequest;
use App\Http\Requests\CampaignUpdateRequest;
use App\Http\Resources\CampaignResource;
use App\Services\BannerService;
use App\Services\CampaignService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdvertisingController
{
    public function __construct(
        private CampaignService $service,
        private BannerService $bannerService
    ) {
    }

    /**
     * @OA\Get(
     *     path="/api/v1/campaigns",
     *     summary="List of Campaigns",
     *     tags={"Campaigns"},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Page",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\MediaType(
     *         mediaType="application/json",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/CampaignsListResponse"
     *              ),
     *              @OA\Property(
     *                 property="meta",
     *                 ref="#/components/schemas/PaginatorMeta"
     *              ),
     *              @OA\Property(
     *                 property="links",
     *                 ref="#/components/schemas/PaginatorLinks"
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad request",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Server error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     * )
     *
     * @return ResourceCollection
     */
    public function list(): ResourceCollection
    {
        $campaigns = $this->service->getCampaigns();

        return CampaignResource::collection($campaigns);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/campaign/{campaign_id}",
     *     summary="Update Campaign.
     *          There is an issue with sending formdata via PUT method, so we send POST with the field _method=PUT",
     *     tags={"Campaigns"},
     *     @OA\Parameter(
     *         name="campaign_id",
     *         in="path",
     *         required=true,
     *         description="Campaign ID",
     *         example="2",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 ref="#/components/schemas/CampaignUpdateRequestBody",
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Success",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/CampaignItem"
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad request",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Server error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     )
     * ),
     *
     * @param int $id
     * @param CampaignUpdateRequest $request
     * @return JsonResource
     * @throws ImageUploadException
     */
    public function update(int $id, CampaignUpdateRequest $request): JsonResource
    {
        $data = $request->validated();

        if (isset($data['pictures'])) {
            $data['pictures'] = $this->bannerService->uploadImages($data['pictures']);
        }

        $campaign = $this->service->update(new CampaignRequestDTO($data));

        return new CampaignResource($campaign);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/campaign",
     *     summary="Create a new Campaign",
     *     tags={"Campaigns"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 ref="#/components/schemas/CampaignCreateRequestBody",
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *          response="201",
     *          description="Success",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                 property="data",
     *                 ref="#/components/schemas/CampaignItem"
     *              ),
     *          )
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad request",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Server error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation error",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     )
     * ),
     *
     * @param CampaignCreateRequest $request
     * @return JsonResource
     * @throws ImageUploadException
     */
    public function create(CampaignCreateRequest $request): JsonResource
    {
        $data = $request->validated();

        $data['pictures'] = $this->bannerService->uploadImages($data['pictures']);

        $campaign = $this->service->create(new CampaignRequestDTO($data));

        return new CampaignResource($campaign);
    }
}
