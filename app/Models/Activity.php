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


	public function scopeByUserId($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByDates($query, $start, $end)
    {
        return $query->whereBetween('date_creation', [$start, $end]);
    }

    public function scopeWithoutGps($query)
    {
        return $query->where('action', '<>', 'gps');
    }

    public function scopeWithoutLogin($query)
    {
        return $query->where('action', '<>', 'login');
    }

    public function scopeTodayUserWaypoints($query, $userId)
    {
        $date = now()->toDateString();
        return $query->where('user_id', $userId)
            ->whereDate('date_creation', $date)
            ->orderBy('id');
    }

    public function countUserActivities($userId, $start = null, $end = null)
    {
        $query = $this->byUserId($userId);

        if ($start && $end) {
            $query = $query->byDates($start, $end);
        }

        return $query->withoutGps()->count();
    }
}
