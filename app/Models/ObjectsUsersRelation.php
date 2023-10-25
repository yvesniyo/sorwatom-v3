<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ObjectsUsersRelation
 * 
 * @property int $id
 * @property int $object_id
 * @property int $user_id
 * @property string $object_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class ObjectsUsersRelation extends Model
{
	protected $table = 'objects_users_relations';

	protected $casts = [
		'object_id' => 'int',
		'user_id' => 'int'
	];

	protected $fillable = [
		'object_id',
		'user_id',
		'object_type'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
