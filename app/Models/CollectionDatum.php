<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CollectionDatum
 * 
 * @property int $id
 * @property string $device_name
 * @property string $air_temp
 * @property string $soil_temp
 * @property string $soil_moist
 * @property string $air_hum
 * @property string $lat
 * @property string $lon
 * @property Carbon $date_in
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class CollectionDatum extends Model
{
	protected $table = 'collection_data';

	protected $casts = [
		'date_in' => 'datetime'
	];

	protected $fillable = [
		'device_name',
		'air_temp',
		'soil_temp',
		'soil_moist',
		'air_hum',
		'lat',
		'lon',
		'date_in'
	];
}
