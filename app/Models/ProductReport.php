<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductReport
 * 
 * @property int $id
 * @property int $product_id
 * @property int $quantiy
 * @property int $report_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 *
 * @package App\Models
 */
class ProductReport extends Model
{
	protected $table = 'product_reports';

	protected $casts = [
		'product_id' => 'int',
		'quantiy' => 'int',
		'report_id' => 'int'
	];

	protected $fillable = [
		'product_id',
		'quantiy',
		'report_id'
	];




	public function reportUser()
	{
		return $this->belongsTo(User::class, 'user_id'); // Assuming there is a 'users' table with 'id' as the foreign key
	}

	public function product()
	{
		return $this->belongsTo(Product::class, 'product_id');
	}

	public static function saveReportedProduct(int $product_id, int|float $quantity, int $report_id, int $user_id)
	{
		$reportedProduct = new ProductReport([
			'product_id' => $product_id,
			'quantity' => $quantity,
			'report_id' => $report_id,
			'user_id' => $user_id,
		]);

		if ($reportedProduct->save()) {
			return $reportedProduct;
		}

		return null;
	}

	public function scopeByReportId($query, $reportId)
	{
		return $query->where('report_id', $reportId);
	}

	public function scopeWithProduct($query)
	{
		return $query->with('product');
	}
}
