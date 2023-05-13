<?php

namespace App\Models;

use App\Enum\SalesOrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property string $status
 * @property int $number_of_sell
 * @property string $color
 * @property string $size
 * @property string $time_confirm
 * @property string $time_delivery
 *
 */
class SalesOrder extends Model
{
    use HasFactory, AsSource;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'status',
        'number_of_sell',
        'color',
        'size',
        'time_confirm',
        'time_delivery'
    ];

    protected $casts = [
        'status' => SalesOrderStatus::class,

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
