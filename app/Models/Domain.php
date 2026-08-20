<?php

namespace App\Models;

use App\Enums\Domain\SslStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Domain extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'verification_token',
        'is_verified',
        'verified_at',
        'ssl_issued_at',
        'ssl_status',
        'ssl_error_log',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'ssl_issued_at' => 'datetime',
        'ssl_status' => SslStatusEnum::class,
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function ($domain) {
            $domain->verification_token = 'shelfcurator-verify-'.Str::random(16);
        });
    }

    /**
     * Get the user that owns the domain.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
