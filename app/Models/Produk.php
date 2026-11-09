<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    public const STATUS_MENUNGGU = 'menunggu';

    public const STATUS_DISETUJUI = 'disetujui';

    public const STATUS_DITOLAK = 'ditolak';

    public const STATUSES = [
        self::STATUS_MENUNGGU,
        self::STATUS_DISETUJUI,
        self::STATUS_DITOLAK,
    ];

    protected $fillable = [
        'user_id',
        'kategori_id',
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'foto',
        'status',
        'alasan_penolakan',
    ];

    protected $casts = [
        'harga' => 'integer',
        'stok' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function scopeDisetujui(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_DISETUJUI);
    }

    public function isDisetujui(): bool
    {
        return $this->status === self::STATUS_DISETUJUI;
    }

    public function isMenunggu(): bool
    {
        return $this->status === self::STATUS_MENUNGGU;
    }

    public function isDitolak(): bool
    {
        return $this->status === self::STATUS_DITOLAK;
    }

    /**
     * Public URL for the product image, or a placeholder data URI.
     */
    public function fotoUrl(): string
    {
        if ($this->foto && Storage::disk('public')->exists($this->foto)) {
            return Storage::disk('public')->url($this->foto);
        }

        // Gunakan placeholder gambar dengan inisial nama produk
        $initial = mb_substr($this->nama, 0, 1);
        $backgroundColor = dechex(crc32($this->nama) & 0xFFFFFF);
        
        // Menggunakan ui-avatars.com untuk generate placeholder
        return "https://ui-avatars.com/api/?name=" . urlencode($initial) 
            . "&size=400&background=" . $backgroundColor 
            . "&color=fff&bold=true&format=svg";
    }

    public function labelStatus(): string
    {
        return match ($this->status) {
            self::STATUS_DISETUJUI => 'Disetujui',
            self::STATUS_DITOLAK => 'Ditolak',
            default => 'Menunggu',
        };
    }

    /**
     * Normalize a WhatsApp number into international digits (62...) for wa.me.
     */
    public function whatsappOrderUrl(): ?string
    {
        $number = $this->user?->whatsapp_number;

        if (! $number) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $number);

        if (str_starts_with($digits, '0')) {
            $digits = '62'.substr($digits, 1);
        } elseif (str_starts_with($digits, '8')) {
            $digits = '62'.$digits;
        } elseif (str_starts_with($digits, '620')) {
            $digits = '62'.substr($digits, 3);
        }

        $message = rawurlencode(
            "Halo {$this->user->name}, saya menemukan produk \"{$this->nama}\" di KatalogPreneur UB "
            ."dan tertarik untuk memesannya. Apakah produk ini masih tersedia?"
        );

        return "https://wa.me/{$digits}?text={$message}";
    }

    public function rupiah(): string
    {
        return 'Rp '.number_format($this->harga, 0, ',', '.');
    }
}
