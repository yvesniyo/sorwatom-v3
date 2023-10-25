<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 * 
 * @property int $id
 * @property string $name
 * @property string $company
 * @property string $phone
 * @property string $type
 * @property string $address
 * @property string $road
 * @property Carbon $created_date
 * @property int $status
 * @property string $location
 * @property string $whatsapp_number
 * @property string $tva_pic
 * @property string $id_pic
 * @property string $company_reg_pic
 * @property string $country
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Order[] $orders
 * @property Collection|Payment[] $payments
 *
 * @package App\Models
 */
class Customer extends Model
{
	protected $table = 'customers';

	protected $casts = [
		'created_date' => 'datetime',
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'company',
		'phone',
		'type',
		'address',
		'road',
		'created_date',
		'status',
		'location',
		'whatsapp_number',
		'tva_pic',
		'id_pic',
		'company_reg_pic',
		'country'
	];

	public function orders()
	{
		return $this->hasMany(Order::class, 'client_id');
	}

	public function payments()
	{
		return $this->hasMany(Payment::class);
	}
}
