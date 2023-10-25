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

	public function product()
	{
		return $this->belongsTo(Product::class);
	}
}
