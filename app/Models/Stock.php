<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Stock
 * 
 * @property int $id
 * @property int $product_id
 * @property float $quantity
 * @property string $options
 * @property int $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Stock extends Model
{
	protected $table = 'stock';

	protected $casts = [
		'product_id' => 'int',
		'quantity' => 'float',
		'updated_by' => 'int'
	];

	protected $fillable = [
		'product_id',
		'quantity',
		'options',
		'updated_by'
	];
}
