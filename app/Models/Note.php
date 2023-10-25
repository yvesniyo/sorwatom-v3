<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Note
 * 
 * @property int $id
 * @property string $comment
 * @property string $type
 * @property int $object_id
 * @property int $added_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Note extends Model
{
	protected $table = 'notes';

	protected $casts = [
		'object_id' => 'int',
		'added_by' => 'int'
	];

	protected $fillable = [
		'comment',
		'type',
		'object_id',
		'added_by'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'added_by');
	}
}
