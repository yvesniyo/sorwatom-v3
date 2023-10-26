<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * 
 * @property int $id
 * @property int $client_id
 * @property Carbon $date
 * @property int $status
 * @property float $amount
 * @property int $added_by
 * @property int $modified_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Customer $customer
 * @property User $user
 * @property Billing $billing
 * @property Collection|Delivery[] $deliveries
 * @property Collection|Product[] $products
 *
 * @package App\Models
 */
class Order extends Model
{
	protected $table = 'orders';

	protected $casts = [
		'client_id' => 'int',
		'date' => 'datetime',
		'status' => 'int',
		'amount' => 'float',
		'added_by' => 'int',
		'modified_by' => 'int'
	];

	protected $fillable = [
		'client_id',
		'date',
		'status',
		'amount',
		'added_by',
		'modified_by'
	];

	public function customer()
	{
		return $this->belongsTo(Customer::class, 'client_id');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'modified_by');
	}

	public function deliveries()
	{
		return $this->hasMany(Delivery::class);
	}

	public function products()
	{
		return $this->belongsToMany(Product::class, 'products_ordered')
					->withPivot('id', 'qty', 'price')
					->withTimestamps();
	}


	public function productsOrdered()
    {
        return $this->hasMany(ProductOrdered::class);
    }

    public function billing()
    {
        return $this->hasOne(Billing::class);
    }

    public function delivery()
    {
        return $this->hasOne(Delivery::class);
    }

    public function objectRelationship()
    {
        return $this->hasOne(ObjectRelationship::class, 'object_id')->where('object_type', 'order');
    }

    public function saveOrder($client, $status, $addedBy, $modifiedBy)
    {
        $order = new Order();
        $order->client = $client;
        $order->date = now();
        $order->status = $status;
        $order->amount = 0; // Calculate the amount as needed
        $order->added_by = $addedBy;
        $order->modified_by = $modifiedBy;
        $order->save();

        return $order;
    }

    public function getOrders()
    {
        return Order::with(['billing', 'delivery', 'productsOrdered'])->orderBy('id', 'DESC')->get();
    }

    // Implement other methods to get orders by date, for a specific country, etc.

    public function countPendingOrders()
    {
        return $this->where('status', 0)->count();
    }

    // Implement other count methods

    public function getOrderById($id)
    {
        return Order::with(['billing', 'delivery', 'productsOrdered'])->find($id);
    }

    public function getTodaysOrders()
    {
        return Order::with(['billing', 'delivery', 'productsOrdered'])
            ->whereDate('date', today())
            ->orderBy('id', 'DESC')
            ->get();
    }

    // Implement other order retrieval methods

    public function updateOrderStatus($field, $value)
    {
        return $this->update([$field => $value]);
    }

    public function getOrdersForCustomer($customerId, $limit = 1)
    {
        return Order::with(['billing', 'delivery', 'productsOrdered'])
            ->where('client', $customerId)
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->get();
    }

    public function getOrdersByUser($userId)
    {
        return Order::with(['productsOrdered' => function ($query) {
            $query->select('product_ordered_id', 'product_id', 'order_id', 'qty');
        }])
        ->whereHas('objectRelationship', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('object_type', 'order');
        })
        ->where('date', '>=', now()->subDay())
        ->orderBy('client')
        ->get();
    }
}
