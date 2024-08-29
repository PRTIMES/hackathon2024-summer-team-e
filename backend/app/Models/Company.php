<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "popularity",
        "company_id",
        "industry_id"
    ];

    /**
     * @return HasMany
     */
    public function press_releases(): HasMany
    {
        return $this->hasMany(PressRelease::class, 'company_id', 'company_id');
    }
}
