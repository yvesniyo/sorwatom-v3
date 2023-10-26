<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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


	public function saveObjectRelationship($object_id, $user_id, $object_type)
	{
		$objectRelationship = new ObjectsUsersRelation();
		$objectRelationship->object_id = $object_id;
		$objectRelationship->user_id = $user_id;
		$objectRelationship->object_type = $object_type;
		$objectRelationship->save();

		return $objectRelationship;
	}

	public function getObjectByTypeAndId($type, $id)
	{
		return $this->where('object_type', $type)
			->where('object_id', $id)
			->first();
	}

	public function getObjectsByUser($object_type, $user_id)
	{
		return $this->where('object_type', $object_type)
			->where('user_id', $user_id)
			->get();
	}

	public function getActivitiesByUser($user_id)
	{
		return $this->select('*', DB::raw('count(*) as c'))
			->where('user_id', $user_id)
			->groupBy('object_type')
			->get();
	}
}
