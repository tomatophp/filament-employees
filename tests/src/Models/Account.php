<?php

namespace TomatoPHP\FilamentEmployees\Tests\Models;

use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use TomatoPHP\FilamentEmployees\Tests\Database\Factories\AccountFactory;
use TomatoPHP\FilamentEmployees\Traits\IsEmployee;

/**
 * The account model a host app publishes from filament-accounts, with the employees trait added.
 */
class Account extends Authenticatable implements HasAvatar, HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use IsEmployee;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'accounts';

    protected $fillable = [
        'email',
        'phone',
        'parent_id',
        'type',
        'name',
        'username',
        'loginBy',
        'address',
        'password',
        'is_login',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_login' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->getFirstMediaUrl('avatar') ?: null;
    }

    protected static function newFactory(): AccountFactory
    {
        return AccountFactory::new();
    }
}
