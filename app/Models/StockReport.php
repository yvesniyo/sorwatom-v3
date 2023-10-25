<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StockReport
 * 
 * @property int $id
 * @property int $customer_id
 * @property Carbon $date
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StockReport extends Model
{
	protected $table = 'stock_reports';

	protected $casts = [
		'customer_id' => 'int',
		'date' => 'datetime',
		'status' => 'int'
	];

	protected $fillable = [
		'customer_id',
		'date',
		'status'
	];
}
