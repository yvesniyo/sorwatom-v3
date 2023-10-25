<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserDistanceTracking
 * 
 * @property int $id
 * @property int $user_id
 * @property string $distance
 * @property string $starting_location
 * @property string $ending_location
 * @property Carbon $starting_time
 * @property Carbon $ending_time
 * @property Carbon $date_day
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class UserDistanceTracking extends Model
{
	protected $table = 'user_distance_tracking';

	protected $casts = [
		'user_id' => 'int',
		'starting_time' => 'datetime',
		'ending_time' => 'datetime',
		'date_day' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'distance',
		'starting_location',
		'ending_location',
		'starting_time',
		'ending_time',
		'date_day'
	];
}
