<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Menu extends Model
{
    use HasFactory;

    // Pastikan semua atribut yang diperlukan bisa diisi
    protected $fillable = ['name', 'price', 'category_id', 'stock', 'image', 'description'];

    /**
     * Relasi ke OrderDetail (satu menu bisa ada di banyak order detail)
     */
    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Relasi ke Category (satu menu hanya punya satu kategori)
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
