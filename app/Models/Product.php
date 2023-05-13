<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
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
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'name',
        'slug',
        'ingredient',
        'category_id',
        'supplier_id',
        'total'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

}
