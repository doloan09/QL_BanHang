<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class ColorProduct extends Model
{
    use HasFactory, AsSource;

    protected $table = 'product_colors';
    protected $fillable = [
        'color_id',
        'product_id',
    ];

}
