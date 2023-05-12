<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $ingredient
 * @property int $category_id
 * @property int $supplier_id
 * @property int $total
 *
 */

class Product extends Model
{
    use HasFactory, AsSource;

    protected $fillable = [
        'name',
        'slug',
        'ingredient',
        'category_id',
        'supplier_id',
        'total'
    ];
}
