<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Car
 * 
 * @property int $id
 * @property string $name
 * @property float $capacity
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|LoadedOrder[] $loaded_orders
 *
 * @package App\Models
 */
class Car extends Model
{
	protected $table = 'cars';

	protected $casts = [
		'capacity' => 'float',
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'capacity',
		'status'
	];

	public function loaded_orders()
	{
		return $this->hasMany(LoadedOrder::class);
	}
}
