<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * 
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $price
 * @property string $remarks
 * @property int $added_by
 * @property int $status
 * @property string $gallery
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Country[] $countries
 * @property Collection|ProductReport[] $product_reports
 * @property Collection|Order[] $orders
 * @property Collection|SalesReport[] $sales_reports
 * @property Collection|StockRequest[] $stock_requests
 *
 * @package App\Models
 */
class Product extends Model
{
	protected $table = 'products';

	protected $casts = [
		'added_by' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'type',
		'price',
		'remarks',
		'added_by',
		'status',
		'gallery'
	];

	public function countries()
	{
		return $this->belongsToMany(Country::class, 'product_country_prices')
					->withPivot('id', 'price', 'status')
					->withTimestamps();
	}

	public function product_reports()
	{
		return $this->hasMany(ProductReport::class);
	}

	public function orders()
	{
		return $this->belongsToMany(Order::class, 'products_ordered')
					->withPivot('id', 'qty', 'price')
					->withTimestamps();
	}

	public function sales_reports()
	{
		return $this->hasMany(SalesReport::class);
	}

	public function stock_requests()
	{
		return $this->hasMany(StockRequest::class);
	}
}
