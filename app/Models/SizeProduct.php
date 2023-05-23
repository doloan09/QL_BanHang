<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class SizeProduct extends Model
{
    use HasFactory, AsSource;

    protected $table = 'product_sizes';

    protected $fillable = [
        'size_id',
        'product_id'
    ];

}
