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

    public function colors($id)
    {
        $list = Product::query()
            ->select('colors.id', 'colors.name')
            ->join('product_colors', 'product_colors.product_id', 'products.id')
            ->join('colors', 'colors.id', 'product_colors.color_id')
            ->where('products.id', $id)
            ->get();

        return $list;
    }

    public function sizes($id)
    {
        $list = Product::query()
            ->select('sizes.id', 'sizes.name')
            ->join('product_sizes', 'product_sizes.product_id', 'products.id')
            ->join('sizes', 'sizes.id', 'product_sizes.size_id')
            ->where('products.id', $id)
            ->get();

        return $list;
    }

}
