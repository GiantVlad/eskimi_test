<?php

namespace Database\Factories;

use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $dateFrom = Carbon::createFromTimeStamp($this->faker->dateTimeBetween('-2 years', 'now')->getTimestamp());
        $dateTo = $dateFrom->copy()->addDays($this->faker->numberBetween(1, 365));
        $diff = $dateTo->diffInDays($dateFrom) + 1;
        $daily = $this->faker->numberBetween(1000, 100000);
        $total = $daily * $diff;

        return [
            'name' => $this->faker->unique()->name(),
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'daily_budget' => $daily,
            'total_budget' => $total,
        ];
    }
}
