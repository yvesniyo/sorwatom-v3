<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Country
 * 
 * @property int $id
 * @property string $name
 * @property string $code
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Product[] $products
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Country extends Model
{
	protected $table = 'countries';

	protected $fillable = [
		'name',
		'code'
	];

	public function products()
	{
		return $this->belongsToMany(Product::class, 'product_country_prices')
					->withPivot('id', 'price', 'status')
					->withTimestamps();
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
