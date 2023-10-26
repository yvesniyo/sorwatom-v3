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

	public function saveDelivery($order_id, $province, $district, $street, $receiver_name, $status)
    {
        $delivery = new Delivery();
        $delivery->order_id = $order_id;
        $delivery->province = $province;
        $delivery->district = $district;
        $delivery->street = $street;
        $delivery->receiver_name = $receiver_name;
        $delivery->quantity = 0; // You can set the initial quantity as needed
        $delivery->status = $status;
        $delivery->created_date = now();
        $delivery->delivery_date = null;
        $delivery->save();

        return $delivery;
    }

    public function getDeliveryForOrder(int $order_id)
    {
        return $this->where('order_id', $order_id)->get();
    }

    public function updateDeliveryStatus(int $order_id,int $status)
    {
        $delivery = $this->where('order_id', $order_id)->first();

        if ($delivery) {
            $delivery->status = $status;

            if ($status == 1) {
                $delivery->delivery_date = now();
            }

            $delivery->save();

            return true;
        }

        return false;
    }
}
