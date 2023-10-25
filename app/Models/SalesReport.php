<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesReport
 * 
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property float $quantity
 * @property Carbon $date
 * @property string $place
 * @property int $stock_request_id
 * @property string $geolocation
 * @property string $client_name
 * @property string $client_phone
 * @property string $team
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 * @property StockRequest $stock_request
 *
 * @package App\Models
 */
class SalesReport extends Model
{
	protected $table = 'sales_report';

	protected $casts = [
		'product_id' => 'int',
		'user_id' => 'int',
		'quantity' => 'float',
		'date' => 'datetime',
		'stock_request_id' => 'int'
	];

	protected $fillable = [
		'product_id',
		'user_id',
		'quantity',
		'date',
		'place',
		'stock_request_id',
		'geolocation',
		'client_name',
		'client_phone',
		'team'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function stock_request()
	{
		return $this->belongsTo(StockRequest::class);
	}
}
