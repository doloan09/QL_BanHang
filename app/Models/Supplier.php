<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

/**
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $phone
 *
 */

class Supplier extends Model
{
    use HasFactory, AsSource;

    /**
     * @var string[]
     */
    protected $fillable = [
      'name',
      'address',
      'phone'
    ];

}
