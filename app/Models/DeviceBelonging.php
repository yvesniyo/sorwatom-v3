<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DeviceBelonging
 * 
 * @property int $id
 * @property string $device_id
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class DeviceBelonging extends Model
{
	protected $table = 'device_belonging';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'device_id',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
