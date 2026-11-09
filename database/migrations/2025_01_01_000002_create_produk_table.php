<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('kategori_id')->constrained('kategori')->restrictOnDelete();
            $table->string('nama');
            $table->text('deskripsi');
            $table->unsignedBigInteger('harga')->default(0);
            $table->unsignedInteger('stok')->default(0);
            $table->string('foto')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak'])
                ->default('menunggu')
                ->index();
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('kategori_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
