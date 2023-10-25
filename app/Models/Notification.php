<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * 
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property string $message
 * @property int $status
 * @property int $read
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notifications';

	protected $casts = [
		'user_id' => 'int',
		'type' => 'int',
		'status' => 'int',
		'read' => 'int'
	];

	protected $fillable = [
		'user_id',
		'type',
		'message',
		'status',
		'read'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
