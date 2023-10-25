<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LoadedOrder
 * 
 * @property int $id
 * @property int $confirmed_order_id
 * @property int $car_id
 * @property int $driver_id
 * @property Carbon $datetime
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Car $car
 *
 * @package App\Models
 */
class LoadedOrder extends Model
{
	protected $table = 'loaded_orders';

	protected $casts = [
		'confirmed_order_id' => 'int',
		'car_id' => 'int',
		'driver_id' => 'int',
		'datetime' => 'datetime',
		'status' => 'int'
	];

	protected $fillable = [
		'confirmed_order_id',
		'car_id',
		'driver_id',
		'datetime',
		'status'
	];

	public function car()
	{
		return $this->belongsTo(Car::class);
	}
}
