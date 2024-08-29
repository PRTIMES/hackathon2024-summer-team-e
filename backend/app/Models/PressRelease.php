<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PressRelease extends Model
{
    use HasFactory;

    protected $fillable = [
        "company_id",
        "release_id",
        "title",
        "summary",
        "release_created_at"
    ];

    /**
     * @return BelongsToMany
     */
    public function keywords(): BelongsToMany
    {
        return $this->belongsToMany(Keyword::class);
    }
}
