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


	public function saveLoadedOrder($confirmed_order_id, $car_id, $driver_id)
	{
		$loadedOrder = new LoadedOrder();
		$loadedOrder->confirmed_order_id = $confirmed_order_id;
		$loadedOrder->car_id = $car_id;
		$loadedOrder->driver_id = $driver_id;
		$loadedOrder->save();

		return $loadedOrder;
	}

	public function getLoadedOrders()
	{
		return $this->join('orders', 'orders.id', '=', 'loaded_order.confirmed_order_id')
			->select('loaded_order.*')
			->get();
	}

	public function getLoadedOrderByOrderID($order_id)
	{
		return $this->join('orders', 'orders.id', '=', 'loaded_order.confirmed_order_id')
			->select('loaded_order.*')
			->where('orders.id', $order_id)
			->get();
	}

	public function getLoadedCarByOrderID($order_id)
	{
		return $this->where('confirmed_order_id', $order_id)
			->select('car_id')
			->get();
	}
}
