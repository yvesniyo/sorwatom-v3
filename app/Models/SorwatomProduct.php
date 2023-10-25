<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SorwatomProduct
 * 
 * @property int $id
 * @property int $product_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SorwatomProduct extends Model
{
	protected $table = 'sorwatom_products';

	protected $casts = [
		'product_id' => 'int'
	];

	protected $fillable = [
		'product_id'
	];
}
