<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'hash_email',
        'job',
        'age',
        'prefecture'
    ];

    /**
     * @return HasMany
     */
    public function view_histories(): HasMany
    {
        return $this->hasMany(ViewHistory::class);
    }
}
