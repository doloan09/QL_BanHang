<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property int $product_id
 * @property int $supplier_id
 * @property int $number_of_import
 *
 */

class ImportOrder extends Model
{
    use HasFactory, AsSource;

    /**
     * @var string[]
     */
    protected $fillable = [
        'product_id',
        'supplier_id',
        'number_of_import',
    ];

}
