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



	class User
	{
		var $id, $firstname, $lastname, $options, $creation_date, $modified_date, $type, $status, $phone, $email, $url, $password, $address, $image, $whatsapp_number, $country, $category;
		function __construct()
		{
		}
		function initiate_data($attrs)
		{
			if ($attrs != null) {
				foreach ($attrs as $attr => $value) {
					$this->{$attr} = $value;
				}
			}
		}
		public static function all()
		{
			$query = "SELECT * FROM users";
			$rows = new MysqliRequest($query);
			if ($rows->status) {
				$rows = $rows->getRows();
				return $rows;
			}
			return false;
		}
		public static function find($id)
		{
			$query = "SELECT * FROM users WHERE id='$id' limit 1";
			$rows = new MysqliRequest($query);
			if ($rows->status) {
				$rows = $rows->getRows();
				if (isset($rows[0])) {
					return $rows[0];
				}
			}
			return false;
		}
		function update($field, $value)
		{
			$qry = "UPDATE users SET $field='$value' WHERE id=$this->id";
			$rslt = new MysqliRequest($qry);
			if ($rslt->status != false and $rslt->rows > 0) {
				return true;
			} else {
				return false;
			}
		}
		function general_update($attrs)
		{
			$qry = "UPDATE users SET ";
			$i = 0;
			foreach ($attrs as $attr => $value) {
				$qry .= "$attr='$value'";
				if ($i < (count($attrs) - 1)) {
					$qry .= ',';
				}

				$i++;
			}
			$qry .= " WHERE email='" . $attrs['email'] . "'";
			$rslt = new MysqliRequest($qry);
			file_put_contents("rslt", $qry);
			if ($rslt->status != false and $rslt->rows > 0) {
				return true;
			} else {
				return false;
			}
		}
		function get_user_by_field($field, $value)
		{
			$qry = "SELECT * FROM users WHERE $field='" . $value . "'";
			$rslt = new MysqliRequest($qry);
			if ($rslt->status != false and $rslt->rows > 0) {
				$data = mysqli_fetch_assoc($rslt->result);
				foreach ($data as $attr => $value) {
					$this->{$attr} = $value;
				}
				return $this;
			} else {
				return null;
			}
		}
		function get_user_by_id($id)
		{
			$qry = "SELECT * FROM users WHERE id='$id'";
			$rslt = new MysqliRequest($qry);

			if ($rslt->status != false and $rslt->rows > 0) {
				$data = mysqli_fetch_assoc($rslt->result);
				foreach ($data as $attr => $value) {
					$this->{$attr} = $value;
				}
				return $this;
			} else {
				return null;
			}
		}
		function get_user_by_unicity($value, $password)
		{

			$new_pass =  md5('@%GNU??' . $password . '14AFR*%');
			$qry = "SELECT * FROM users WHERE (email='$value' OR phone='$value') AND password='$new_pass'";
			file_put_contents('get_by_id', $qry);
			$rslt = new MysqliRequest($qry);
			if ($rslt->status != false and $rslt->rows > 0) {
				$data = mysqli_fetch_assoc($rslt->result);
				$user_data = new User();
				foreach ($data as $attr => $value) {
					$user_data->$attr = $value;
				}
				return $user_data;
			} else {
				return null;
			}
		}
		function get_all_users()
		{
			$rqst = "SELECT * FROM users";
			$rslt = new MysqliRequest($rqst);
			if ($rslt->status != false and $rslt->rows > 0) {
				$users = array();
				while ($data = mysqli_fetch_assoc($rslt->result)) {
					$user_data = new User();
					foreach ($data as $attr => $value) {
						$user_data->{$attr} = $value;
					}
					array_push($users, $user_data);
				}
				return $users;
			}
		}
		function get_all_users_id()
		{
			$rqst = "SELECT id FROM users";
			$rslt = new MysqliRequest($rqst);
			if ($rslt->status != false and $rslt->rows > 0) {
				$users = array();
				while ($data = mysqli_fetch_assoc($rslt->result)) {
					$user_data = new User();
					foreach ($data as $attr => $value) {
						$user_data->{$attr} = $value;
					}
					array_push($users, $user_data);
				}
				return $users;
			}
		}
		function get_all_users_like()
		{
			$rqst = "SELECT id,firstname,lastname,users.type,users.status,category,country,testing FROM users";
			$rslt = new MysqliRequest($rqst);
			if ($rslt->status != false and $rslt->rows > 0) {
				$users = array();
				while ($data = mysqli_fetch_assoc($rslt->result)) {
					array_push($users, $data);
				}
				return $users;
			}
		}
		function save()
		{
			$new_pass =  md5('@%GNU??' . $this->password . '14AFR*%');
			$this->type = 'N';
			$qry = "INSERT INTO users (firstname,lastname,category,phone,email,password,status,address,creation_date,modified_date,type,options,image,whatsapp_number,country,testing)
			 VALUES ('$this->firstname','$this->lastname','$this->category','$this->phone','$this->email','$new_pass','1','$this->address',NOW(),NOW(),'$this->type','$this->options','$this->image','$this->whatsapp_number','$this->country','no')";
			file_put_contents('user_to_save', $qry);

			$rslt = new MysqliRequest($qry);

			if ($rslt->status != false) {
				return true;
			}
			return false;
		}

		function activate_account($email, $phone, $activation_code)
		{
			$qry = "SELECT * FROM confirmation_table WHERE confirmation_code='$activation_code' AND (email='$email' OR phone='$phone')";
			$rslt = new MysqliRequest($qry);
			if ($rslt->status != false && $rslt->rows > 0) {
				$data = $rslt->result->fetch_assoc();
				if ($data['email'] = $email or $data['phone_number'] == $phone) {
					$qry2 = "UPDATE confirmation_table SET confirmed=1 WHERE confirmation_code='$activation_code' AND (email='$email' OR phone_number='$phone')";
					new MysqliRequest($qry2);
					$o = $this->get_user_by_field('email', $email);
					if ($o != null) {

						return $o->update('status', '1');
					}
				}
			}
			return false;
		}
		function isMarchandise($id)
		{
			$query = "SELECT category from users where category='ma' and id= '$id'";
			$rslt = new MysqliRequest($query);
			if ($rslt->status != false and $rslt->rows > 0) {
				return true;
			} else {
				return false;
			}
		}
		function get_all_users_for_country($country)
		{
			$rqst = "SELECT * FROM users WHERE country LIKE '%$country%'";
			$rslt = new MysqliRequest($rqst);
			if ($rslt->status != false and $rslt->rows > 0) {
				$users = array();
				while ($data = mysqli_fetch_assoc($rslt->result)) {
					$user_data = new User();
					foreach ($data as $attr => $value) {
						$user_data->{$attr} = $value;
					}
					array_push($users, $user_data);
				}
				return $users;
			}
		}
	
}
