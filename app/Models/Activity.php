<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity
 * 
 * @property int $id
 * @property int $user_id
 * @property string $device_id
 * @property string $geoposition
 * @property string $ip
 * @property string $action
 * @property int $distance_calculated
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Activity extends Model
{
	protected $table = 'activities';

	protected $casts = [
		'user_id' => 'int',
		'distance_calculated' => 'int'
	];

	protected $fillable = [
		'user_id',
		'device_id',
		'geoposition',
		'ip',
		'action',
		'distance_calculated'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
