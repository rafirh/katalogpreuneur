<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi',
        'ikon',
    ];

    protected static function booted(): void
    {
        static::saving(function (Kategori $kategori) {
            if (empty($kategori->slug)) {
                $kategori->slug = static::uniqueSlug($kategori->nama, $kategori->id);
            }
        });
    }

    public static function uniqueSlug(string $nama, ?int $ignoreId = null): string
    {
        $base = Str::slug($nama);
        $slug = $base;
        $i = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug !== '' ? $slug : 'kategori-'.Str::random(4);
    }

    public function produk(): HasMany
    {
        return $this->hasMany(Produk::class);
    }

    public function produkDisetujui(): HasMany
    {
        return $this->hasMany(Produk::class)->where('status', Produk::STATUS_DISETUJUI);
    }
}
