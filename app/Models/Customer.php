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


	public function updateField($field, $value)
	{
		return $this->where('id', $this->id)->update([$field => $value]);
	}

	public function generalUpdate($attrs)
	{
		return $this->where('id', $attrs['id'])->update($attrs);
	}

	public function saveCustomer($user_id, $data)
	{
		$customer = $this->create($data);

		// Create an object relationship
		$or = new ObjectRelationship();
		$or->object_id = $customer->id;
		$or->user_id = $user_id;
		$or->object_type = 'customer';
		$or->save();

		return $customer;
	}

	public function getCustomerById($id)
	{
		return $this->find($id);
	}

	public function getT1Customers()
	{
		return $this->where('type', 'T1')->orderBy('name', 'ASC')->get();
	}

	public function getT2Customers()
	{
		return $this->where('type', 'T2')->orderBy('name', 'ASC')->get();
	}

	public function getPCustomers()
	{
		return $this->where('type', 'CUSTOMER PROVINCE')->orderBy('name', 'ASC')->get();
	}

	public function getECustomers()
	{
		return $this->where('type', 'export')->orderBy('name', 'ASC')->get();
	}

	public function getCustomersByCountry($country)
	{
		return $this->where('country', $country)->orderBy('name', 'ASC')->get();
	}

	public function getAllCustomers()
	{
		return $this->orderBy('name', 'ASC')->get();
	}

	public function getCustomersByUser($user)
	{
		return $this
			->select('customers.id', 'name', 'company', 'phone', 'type', 'address', 'road', 'created_date', 'status', 'country', 'location', 'whatsapp_number', 'tva_pic', 'id_pic', 'company_reg_pic')
			->join('objects_users_relations', 'objects_users_relations.object_id', '=', 'customers.id')
			->where('objects_users_relations.user_id', $user)
			->where('objects_users_relations.object_type', 'customer')
			->orderBy('name', 'ASC')
			->get();
	}
}
