<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class UserDistanceTracking
 * 
 * @property int $id
 * @property int $user_id
 * @property string $distance
 * @property string $starting_location
 * @property string $ending_location
 * @property Carbon $starting_time
 * @property Carbon $ending_time
 * @property Carbon $date_day
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class UserDistanceTracking extends Model
{
	protected $table = 'user_distance_tracking';

	protected $casts = [
		'user_id' => 'int',
		'starting_time' => 'datetime',
		'ending_time' => 'datetime',
		'date_day' => 'datetime'
	];

	protected $fillable = [
		'user_id',
		'distance',
		'starting_location',
		'ending_location',
		'starting_time',
		'ending_time',
		'date_day'
	];


	public static function getWeekTracking($date)
	{
		if (!isset($date)) {
			$date = date("Y-m-d");
		} else {
			$date = date("Y-m-d", strtotime($date));
		}
		$week = date("W", strtotime($date));
		$year = date("Y", strtotime($date));
		$startAndEndDate = self::getStartAndEndDate($year, $week);
		$rangeDates = self::getDatesFromRange($startAndEndDate[0], $startAndEndDate[1]);
		unset($rangeDates[count($rangeDates) - 1]);
		unset($rangeDates[count($rangeDates) - 1]);

		$weekDays = $rangeDates;
		$weekDaysLen = count($weekDays);
		$query = DB::query("SELECT DISTINCT user_id,date_day FROM user_distance_tracking WHERE date_day BETWEEN DATE('$startAndEndDate[0]') AND DATE('$startAndEndDate[1]') ");
		$users = new MysqliRequest($query);
		$logs = array();
		if ($users->status) {
			$users = $users->getRows();
			$userslen = count($users);
			if ($userslen > 0) {
				for ($i = 0; $i < $userslen; $i++) {

					$user_id = $users[$i]["user_id"];
					$results = array();
					for ($j = 0; $j < $weekDaysLen; $j++) {
						$day = $weekDays[$j];
						$user_users = DB::query("SELECT * FROM user_distance_tracking WHERE DATE(date_day) = DATE('$day') AND user_id='$user_id'");
						if ($user_users->status) {
							$user_users = $user_users->getRows();
							$results[$day] = isset($user_users[0]) ? $user_users[0] : null;
						}
					}
					$userDetails = User::find($user_id);
					$username = $userDetails["firstname"] . " " . $userDetails["lastname"];
					$logs[$user_id] = $results;
				}
			}
			$all_users = User::all();
			foreach ($all_users as $all_user) {
				$id = $all_user['id'];
				$username = $all_user["firstname"] . " " . $all_user["lastname"];
				if (!isset($logs[$id])) {
					$results = array();
					for ($j = 0; $j < $weekDaysLen; $j++) {
						$day = $weekDays[$j];
						$results[$day] = null;
					}
					$logs[$id] = $results;
					$temp = $logs[$id];
					unset($logs[$id]);
					if (
						strtolower($all_user["category"]) == "rw" ||
						strtolower($all_user["category"]) == "t1" ||
						strtolower($all_user["category"]) == "t2" ||
						strtolower($all_user["category"]) == "ma" ||
						strtolower($all_user["category"]) == "horeca"
					) {

						$logs[$username] = $temp;
					}
				} else {
					$temp = $logs[$id];
					unset($logs[$id]);
					if (
						strtolower($all_user["category"]) == "rw" ||
						strtolower($all_user["category"]) == "t1" ||
						strtolower($all_user["category"]) == "t2" ||
						strtolower($all_user["category"]) == "ma" ||
						strtolower($all_user["category"]) == "horeca"
					) {

						$logs[$username] = $temp;
					}
				}
			}
			$weekDaysLen = count($weekDays);
			return ["dates" => $rangeDates, "results" => $logs];
		}
		return false;
	}

	public static function getUserWeekTracking($user_id, $date)
	{
		if (!isset($date)) {
			$date = date("Y-m-d");
		} else {
			$date = date("Y-m-d", strtotime($date));
		}
		$week = date("W", strtotime($date));
		$year = date("Y", strtotime($date));
		$startAndEndDate = self::getStartAndEndDate($year, $week);
		$rangeDates = self::getDatesFromRange($startAndEndDate[0], $startAndEndDate[1]);
		$tracks =  DB::query("SELECT * FROM user_distance_tracking WHERE date_day BETWEEN DATE('$startAndEndDate[0]') AND DATE('$startAndEndDate[1]')  AND user_id = '$user_id' ORDER BY date_day ASC")->get();
		if ($tracks->status) {
			$tracks = $tracks->getRows();
			$results = array();
			for ($i = 0; $i < count($rangeDates); $i++) {
				$data = self::objArraySearch($tracks, "date_day", $rangeDates[$i]);
				$results[$rangeDates[$i]] = $data;
			}
			return ["dates" => $rangeDates, "tracks" => $results, "tr" => $tracks];
		}

		return false;
	}

	public static function objArraySearch($array, $index, $value)
	{
		foreach ($array as $arrayInf) {
			if ($arrayInf[$index] == $value) {
				return $arrayInf;
			}
		}
		return null;
	}

	public static function getStartAndEndDate($year, $week)
	{
		return [
			(new DateTime())->setISODate($year, $week)->format('Y-m-d'), //start date
			(new DateTime())->setISODate($year, $week, 7)->format('Y-m-d') //end date
		];
	}

	public static function getDatesFromRange($start, $end, $format = 'Y-m-d')
	{
		$array = array();
		$interval = new DateInterval('P1D');

		$realEnd = new DateTime($end);
		$realEnd->add($interval);

		$period = new DatePeriod(new DateTime($start), $interval, $realEnd);

		foreach ($period as $date) {
			$array[] = $date->format($format);
		}

		return $array;
	}
}
