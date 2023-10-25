<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Delegate
 * 
 * @property int $id
 * @property int $user_id
 * @property string $roles
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Delegate extends Model
{
	protected $table = 'delegates';

	protected $casts = [
		'user_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'user_id',
		'roles',
		'status'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
