<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property Carbon $date_from
 * @property Carbon $date_to
 * @property int $daily_budget
 * @property int $total_budget
 */
class Campaign extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'date_from',
        'date_to',
        'daily_budget',
        'total_budget',
    ];

    /**
     * @return HasMany
     */
    public function banners(): HasMany
    {
        return $this->hasMany(Banner::class);
    }
}
