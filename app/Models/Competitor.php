<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Competitor
 * 
 * @property int $id
 * @property int $status
 * @property string $product_name
 * @property string $retailer_price
 * @property string $reseller_price
 * @property string $remarks
 * @property string $pictures
 * @property int $added_by
 * @property string $user_location
 * @property string $supplier
 * @property string $country_code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 * @property Collection|CompetitorsProduct[] $competitors_products
 *
 * @package App\Models
 */
class Competitor extends Model
{
	protected $table = 'competitors';

	protected $casts = [
		'status' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'status',
		'product_name',
		'retailer_price',
		'reseller_price',
		'remarks',
		'pictures',
		'added_by',
		'user_location',
		'supplier',
		'country_code'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'added_by');
	}

	public function competitors_products()
	{
		return $this->hasMany(CompetitorsProduct::class);
	}



	public function getAllByCountry(string $country)
	{
		return $this->where('country_code', $country)->get();
	}

	public function getAllCompetitors()
	{
		return $this->get();
	}

	public function getAllCompetitorsById(int $id)
	{
		return $this->where('id', $id)->get();
	}

	public function saveCompetitor(array $data)
	{
		return $this->create($data);
	}

	public function generalUpdate(int $id, array $attrs)
	{
		return $this->where('id', $id)->update($attrs);
	}

	public function getAllByUser(int $user)
	{
		return $this->where('added_by', $user)->get();
	}

	public function getAllByUserAndCountry(int $user, string $country_code)
	{
		return $this->where('added_by', $user)
			->where("country_code", $country_code)
			->get();
	}
}
