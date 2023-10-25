<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StockRequest
 * 
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property float $quantity
 * @property Carbon $date
 * @property int $proved
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 * @property Collection|SalesReport[] $sales_reports
 *
 * @package App\Models
 */
class StockRequest extends Model
{
	protected $table = 'stock_requests';

	protected $casts = [
		'product_id' => 'int',
		'user_id' => 'int',
		'quantity' => 'float',
		'date' => 'datetime',
		'proved' => 'int'
	];

	protected $fillable = [
		'product_id',
		'user_id',
		'quantity',
		'date',
		'proved'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function sales_reports()
	{
		return $this->hasMany(SalesReport::class);
	}
}
