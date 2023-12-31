<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * 
 * @property int $id
 * @property int $customer_id
 * @property string $proofs
 * @property int $added_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Customer $customer
 * @property User $user
 *
 * @package App\Models
 */
class Payment extends Model
{
	protected $table = 'payments';

	protected $casts = [
		'customer_id' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'customer_id',
		'proofs',
		'added_by'
	];

	public function customer()
	{
		return $this->belongsTo(Customer::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'added_by');
	}


	public function savePayment(int $customer_id, string $proofs, int $added_by)
	{
		$payment = new Payment();
		$payment->customer_id = $customer_id;
		$payment->proofs = $proofs;
		$payment->added_by = $added_by;
		$payment->date_creation = now();
		$payment->save();

		return $payment;
	}

	public function getPayments()
	{
		return Payment::all();
	}

	public function getPaymentsForCustomer(int $customer_id)
	{
		return Payment::where('customer_id', $customer_id)
			->orderBy('date_creation', 'desc')
			->get();
	}
}
