<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConfirmedOrder
 * 
 * @property int $confirmed_order_id
 * @property int $products_ordered_id
 * @property int $qty
 * @property Carbon $datetime
 * @property int $status
 * @property string $invoice_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property ProductsOrdered $products_ordered
 *
 * @package App\Models
 */
class ConfirmedOrder extends Model
{
	protected $table = 'confirmed_order';
	public $incrementing = false;

	protected $casts = [
		'confirmed_order_id' => 'int',
		'products_ordered_id' => 'int',
		'qty' => 'int',
		'datetime' => 'datetime',
		'status' => 'int'
	];

	protected $fillable = [
		'confirmed_order_id',
		'products_ordered_id',
		'qty',
		'datetime',
		'status',
		'invoice_number'
	];

	public function products_ordered()
	{
		return $this->belongsTo(ProductsOrdered::class);
	}
}
