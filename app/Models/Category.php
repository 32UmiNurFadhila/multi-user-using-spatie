<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];

    /**
     * Relasi kategori ke produk (One to Many).
     */
    public function products()
    {
        return $this->hasMany(Menu::class);
    }
}
