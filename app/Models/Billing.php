<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Billing
 * 
 * @property int $id
 * @property int $order_id
 * @property string $company
 * @property string $tin
 * @property string $name
 * @property Carbon $created_date
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Order $order
 *
 * @package App\Models
 */
class Billing extends Model
{
	protected $table = 'billing';

	protected $casts = [
		'order_id' => 'int',
		'created_date' => 'datetime',
		'status' => 'int'
	];

	protected $fillable = [
		'order_id',
		'company',
		'tin',
		'name',
		'created_date',
		'status'
	];

	public function order()
	{
		return $this->belongsTo(Order::class);
	}


	public function getBillingForOrder(int $order_id)
	{
		return $this->where('order_id', $order_id)->get();
	}

	public function saveBilling(int $order_id, string $company, string $tin, string $name, int $status)
	{
		return $this->create([
			'order_id' => $order_id,
			'company' => $company,
			'tin' => $tin,
			'name' => $name,
			'status' => $status,
		]);
	}
}
