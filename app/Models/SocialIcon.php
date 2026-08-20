<?php

namespace App\Models;

use App\Enums\SocialIcon\PlatformEnum;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SocialIcon extends Model
{
    protected $fillable = [
        'user_id',
        'platform',
        'url',
        'order',
        'is_active',
    ];

    protected $casts = [
        'platform' => PlatformEnum::class,
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
