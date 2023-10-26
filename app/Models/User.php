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
use Illuminate\Support\Facades\Hash;
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
		'country_id',
		'category_id',
	];

	public function country()
	{
		return $this->belongsTo(Country::class);
	}

	public function category()
	{
		return $this->belongsTo(UserCategory::class, "user_category_id");
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


	public function get_user_by_unicity($username, $password)
	{

		$user =  User::where("email", $username)
			->orWhere("phone", $username)
			->first();
		if (is_null($user)) {
			return null;
		}

		if (!Hash::check($password, $user->password)) {
			return null;
		}

		return $user;
	}



	public function isMarchandise($id)
	{

		//3 is for marchandise
		return User::where("id", $id)->whereRelation("category", "id", 3)
			->exists();
	}


	public function get_all_users_for_country(int $country_id)
	{

		return User::where("contry_id", $country_id)->get();
	}
}
