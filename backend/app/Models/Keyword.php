<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Keyword extends Model
{
    use HasFactory;

    protected $fillable = [
        "keyword",
        "weight"
    ];

    /**
     * @return BelongsToMany
     */
    public function pressReleases(): BelongsToMany
    {
        return $this->belongsToMany(PressRelease::class);
    }
}
