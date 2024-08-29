<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Keyword extends Model
{
    use HasFactory;

    protected $fillable = [
        "keyword"
    ];

    /**
     * @return HasMany
     */
    public function view_histories(): HasMany
    {
        return $this->hasMany(ViewHistory::class);
    }

    /**
     * @return BelongsToMany
     */
    public function pressReleases(): BelongsToMany
    {
        return $this->belongsToMany(PressRelease::class)
                    ->withPivot("weight");
    }
}
