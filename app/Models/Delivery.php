<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Delivery
 * 
 * @property int $id
 * @property int $order_id
 * @property string $province
 * @property string $district
 * @property string $street
 * @property string $receiver_name
 * @property int $quantity
 * @property int $status
 * @property Carbon $delivery_date
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Order $order
 *
 * @package App\Models
 */
class Delivery extends Model
{
	protected $table = 'deliveries';

	protected $casts = [
		'order_id' => 'int',
		'quantity' => 'int',
		'status' => 'int',
		'delivery_date' => 'datetime'
	];

	protected $fillable = [
		'order_id',
		'province',
		'district',
		'street',
		'receiver_name',
		'quantity',
		'status',
		'delivery_date'
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}
}
