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
 * @property Collection|Billing[] $billings
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

	public function billings()
	{
		return $this->hasMany(Billing::class);
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
}
