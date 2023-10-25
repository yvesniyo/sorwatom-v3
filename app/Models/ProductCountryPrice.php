<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductCountryPrice
 * 
 * @property int $id
 * @property int $product_id
 * @property int $country_id
 * @property float $price
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 * @property Country $country
 *
 * @package App\Models
 */
class ProductCountryPrice extends Model
{
	protected $table = 'product_country_prices';

	protected $casts = [
		'product_id' => 'int',
		'country_id' => 'int',
		'price' => 'float',
		'status' => 'int'
	];

	protected $fillable = [
		'product_id',
		'country_id',
		'price',
		'status'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function country()
	{
		return $this->belongsTo(Country::class);
	}
}
