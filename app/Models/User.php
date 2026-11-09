<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_MAHASISWA = 'mahasiswa';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'whatsapp_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function produk(): HasMany
    {
        return $this->hasMany(Produk::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isMahasiswa(): bool
    {
        return $this->role === self::ROLE_MAHASISWA;
    }

    public function inisial(): string
    {
        $words = preg_split('/\s+/', trim((string) $this->name)) ?: [];

        $initials = collect($words)
            ->filter()
            ->take(2)
            ->map(fn (string $w) => mb_strtoupper(mb_substr($w, 0, 1)))
            ->implode('');

        return $initials !== '' ? $initials : 'U';
    }
}
