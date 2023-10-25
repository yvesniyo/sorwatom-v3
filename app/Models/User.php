<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 * 
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $category
 * @property string $phone
 * @property string $email
 * @property string $password
 * @property int $status
 * @property string $address
 * @property string $type
 * @property string $options
 * @property string $image
 * @property string $whatsapp_number
 * @property int $country_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Country $country
 * @property Collection|Activity[] $activities
 * @property Collection|Competitor[] $competitors
 * @property Collection|CompetitorsProduct[] $competitors_products
 * @property Delegate $delegate
 * @property DeviceBelonging $device_belonging
 * @property Collection|Note[] $notes
 * @property Collection|Notification[] $notifications
 * @property Collection|ObjectsUsersRelation[] $objects_users_relations
 * @property Collection|Order[] $orders
 * @property Collection|Payment[] $payments
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

	protected $table = 'users';

	 /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
		'status' => 'int',
		'country_id' => 'int'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


	 /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
	protected $fillable = [
		'firstname',
		'lastname',
		'category',
		'phone',
		'email',
		'password',
		'status',
		'address',
		'type',
		'options',
		'image',
		'whatsapp_number',
		'country_id'
	];

	public function country()
	{
		return $this->belongsTo(Country::class);
	}

	public function activities()
	{
		return $this->hasMany(Activity::class);
	}

	public function competitors()
	{
		return $this->hasMany(Competitor::class, 'added_by');
	}

	public function competitors_products()
	{
		return $this->hasMany(CompetitorsProduct::class, 'added_by');
	}

	public function delegate()
	{
		return $this->hasOne(Delegate::class);
	}

	public function device_belonging()
	{
		return $this->hasOne(DeviceBelonging::class);
	}

	public function notes()
	{
		return $this->hasMany(Note::class, 'added_by');
	}

	public function notifications()
	{
		return $this->hasMany(Notification::class);
	}

	public function objects_users_relations()
	{
		return $this->hasMany(ObjectsUsersRelation::class);
	}

	public function orders()
	{
		return $this->hasMany(Order::class, 'modified_by');
	}

	public function payments()
	{
		return $this->hasMany(Payment::class, 'added_by');
	}
}
