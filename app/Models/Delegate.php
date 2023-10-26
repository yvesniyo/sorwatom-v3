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


	public function saveDelegate(int $user_id, $roles)
    {
        $delegate = new Delegate();
        $delegate->user_id = $user_id;
        $delegate->roles = $roles;
        $delegate->status = 1;
        $delegate->save();

        return $delegate;
    }

    public function getUserRoles(int $user_id)
    {
        $delegate = $this->where('user_id', $user_id)->first();

        if ($delegate) {
            return $delegate->roles;
        }

        return null;
    }

    public function updateRoles(int $user_id, $value)
    {
        $delegate = $this->where('user_id', $user_id)->first();

        if ($delegate) {
            $delegate->roles = $value;
            $delegate->save();

            return true;
        }

        return false;
    }
}
