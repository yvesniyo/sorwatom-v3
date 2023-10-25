<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CompetitorsProduct
 * 
 * @property int $id
 * @property string $product_name
 * @property int $product_price
 * @property int $competitor_id
 * @property int $status
 * @property Carbon $date_added
 * @property Carbon $date_modified
 * @property string $remark
 * @property int $added_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Competitor $competitor
 * @property User $user
 *
 * @package App\Models
 */
class CompetitorsProduct extends Model
{
	protected $table = 'competitors_products';

	protected $casts = [
		'product_price' => 'int',
		'competitor_id' => 'int',
		'status' => 'int',
		'date_added' => 'datetime',
		'date_modified' => 'datetime',
		'added_by' => 'int'
	];

	protected $fillable = [
		'product_name',
		'product_price',
		'competitor_id',
		'status',
		'date_added',
		'date_modified',
		'remark',
		'added_by'
	];

	public function competitor()
	{
		return $this->belongsTo(Competitor::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'added_by');
	}
}
