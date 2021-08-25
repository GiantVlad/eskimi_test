<?php

declare(strict_types=1);

namespace App\DTO;

class CampaignRequestDTO
{
    private ?int $id;
    private string $name;
    private int $dailyBudget;
    private int $totalBudget;
    private string $dateFrom;
    private string $dateTo;
    private array $pictures;
    private array $imagesToRemove;

    public function __construct(array $data)
    {
        $this->id = isset($data['id']) ? (int)$data['id'] : null;
        $this->name = $data['name'];
        $this->dailyBudget = (int)\bcmul((string)$data['daily_budget'], '100', 2);
        $this->totalBudget = (int)\bcmul((string)$data['total_budget'], '100', 2);
        $this->dateFrom = $data['from'];
        $this->dateTo = $data['to'];
        $this->pictures = $data['pictures'] ?? [];
        $this->imagesToRemove = isset($data['imagesToRemove']) ? array_values($data['imagesToRemove']) : [];
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getDailyBudget(): int
    {
        return $this->dailyBudget;
    }

    /**
     * @return int
     */
    public function getTotalBudget(): int
    {
        return $this->totalBudget;
    }

    /**
     * @return string
     */
    public function getDateFrom(): string
    {
        return $this->dateFrom;
    }

    /**
     * @return string
     */
    public function getDateTo(): string
    {
        return $this->dateTo;
    }

    /**
     * @return string[]
     */
    public function getPictures(): array
    {
        return $this->pictures;
    }

    /**
     * @return array
     */
    public function getImagesToRemove(): array
    {
        return $this->imagesToRemove;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'daily_budget' => $this->dailyBudget,
            'total_budget' => $this->totalBudget,
            'date_from' => $this->dateFrom,
            'date_to' => $this->dateTo,
        ];
    }
}
