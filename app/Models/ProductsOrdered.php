<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsOrdered
 * 
 * @property int $id
 * @property int $product_id
 * @property int $order_id
 * @property float $qty
 * @property float $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 * @property Order $order
 * @property ConfirmedOrder $confirmed_order
 *
 * @package App\Models
 */
class ProductsOrdered extends Model
{
	protected $table = 'products_ordered';

	protected $casts = [
		'product_id' => 'int',
		'order_id' => 'int',
		'qty' => 'float',
		'price' => 'float'
	];

	protected $fillable = [
		'product_id',
		'order_id',
		'qty',
		'price'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function confirmed_order()
	{
		return $this->hasOne(ConfirmedOrder::class);
	}
}
