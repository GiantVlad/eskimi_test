<?php

/**
 * @OA\Info(
 *     title="Advertising manager API",
 *     version="1.0",
 *     @OA\Contact(email="hofirma@gmail.com"),
 * )
 *
 * @OA\Schema(
 *     schema="CampaignsListResponse",
 *     type="array",
 *     @OA\Items(ref="#/components/schemas/CampaignItem"),
 * ),
 * @OA\Schema(
 *     schema="CampaignItem",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example="456"),
 *     @OA\Property(property="name", type="string", example="Name of Campaign"),
 *     @OA\Property(property="from", type="date", example="1976-08-22"),
 *     @OA\Property(property="to", type="date", example="2021-07-25"),
 *     @OA\Property(property="daily_budget", type="float", example="223.45"),
 *     @OA\Property(property="total_budget", type="float", example="3456.98"),
 *     @OA\Property(property="images", type="array", @OA\Items(ref="#/components/schemas/BannerItem")),
 * ),
 * @OA\Schema(
 *     schema="BannerItem",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example="456"),
 *     @OA\Property(property="image_name", type="string", example="image_234.png"),
 * ),
 * @OA\Schema(
 *     schema="PaginatorMeta",
 *     type="object",
 *     @OA\Property(property="meta", type="object",
 *         @OA\Property(property="current_page", type="integer", example="2"),
 *         @OA\Property(property="from", type="integer", example="1"),
 *         @OA\Property(property="path", type="string", example="http://localhost/api/v1/recently-converted"),
 *         @OA\Property(property="per_page", type="integer", example="10"),
 *         @OA\Property(property="to", type="integer", example="10"),
 *    ),
 * ),
 * @OA\Schema(
 *     schema="PaginatorLinks",
 *     type="object",
 *     @OA\Property(property="links", type="object",
 *         @OA\Property(
 *             property="first",
 *             type="string",
 *             example="http://localhost/api/v1/recently-converted?page=2"
 *         ),
 *         @OA\Property(property="last", type="string", nullable="true"),
 *         @OA\Property(property="prev", type="string", nullable="true"),
 *         @OA\Property(property="next", type="string", nullable="true"),
 *    ),
 * ),
 *
 * @OA\Schema(
 *     schema="CampaignUpdateRequestBody",
 *     type="object",
 *     required={"id", "name", "daily_budget", "total_budget", "from", "to", "_method"},
 *     @OA\Property(property="id", type="integer", example="2"),
 *     @OA\Property(property="name", type="string", example="test name"),
 *     @OA\Property(property="daily_budget", type="float", example="123.55"),
 *     @OA\Property(property="total_budget", type="float", example="557.55"),
 *     @OA\Property(property="from", type="date", example="1976-08-22"),
 *     @OA\Property(property="to", type="date", example="2021-07-25"),
 *     @OA\Property(property="_method", type="string", example="PUT"),
 *     @OA\Property(
 *         description="Banner image",
 *         property="pictures[]",
 *         type="array",
 *         @OA\Items(type="file", format="binary")
 *     ),
 *     @OA\Property(
 *         description="Banner to remove",
 *         property="imagesToRemove[]",
 *         type="array",
 *         @OA\Items(type="integer", example="1")
 *     ),
 * ),
 * @OA\Schema(
 *     schema="CampaignCreateRequestBody",
 *     type="object",
 *     required={"name", "daily_budget", "total_budget", "from", "to", "pictures[]"},
 *     @OA\Property(property="name", type="string", example="name example"),
 *     @OA\Property(property="daily_budget", type="float", example="123.55"),
 *     @OA\Property(property="total_budget", type="float", example="557.55"),
 *     @OA\Property(property="from", type="date", example="1976-08-22"),
 *     @OA\Property(property="to", type="date", example="2021-07-25"),
 *     @OA\Property(
 *         description="Banner image",
 *         property="pictures[]",
 *         type="array",
 *         @OA\Items(type="file", format="binary")
 *     ),
 * ),
 *
 * @OA\Schema(
 *     schema="ErrorResponse",
 *     type="object",
 *     @OA\Property(property="message", type="string")
 * ),
 * @OA\Schema(
 *     schema="ValidationError",
 *     type="object",
 *     @OA\Property(property="message", type="string", example="The given data was invalid."),
 *     @OA\Property(property="errors", type="object",
 *         @OA\Property(property="name", type="array",
 *             @OA\Items(type="string", example="The name field is required.")
 *         ),
 *     ),
 * ),
 */
