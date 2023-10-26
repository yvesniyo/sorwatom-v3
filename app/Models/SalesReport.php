<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SalesReport
 * 
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property float $quantity
 * @property Carbon $date
 * @property string $place
 * @property int $stock_request_id
 * @property string $geolocation
 * @property string $client_name
 * @property string $client_phone
 * @property string $team
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 * @property StockRequest $stock_request
 *
 * @package App\Models
 */
class SalesReport extends Model
{
	protected $table = 'sales_report';

	protected $casts = [
		'product_id' => 'int',
		'user_id' => 'int',
		'quantity' => 'float',
		'date' => 'datetime',
		'stock_request_id' => 'int'
	];

	protected $fillable = [
		'product_id',
		'user_id',
		'quantity',
		'date',
		'place',
		'stock_request_id',
		'geolocation',
		'client_name',
		'client_phone',
		'team'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function stock_request()
	{
		return $this->belongsTo(StockRequest::class);
	}


	public function getRequestsForUser($user_id)
	{
		return $this->where('user_id', $user_id)->get();
	}

	public function getRequests()
	{
		return $this->orderBy('id', 'desc')->get();
	}

	public function getRequestsByPeriod($start, $end)
	{
		return $this->whereDate('date', '>=', $start)
			->whereDate('date', '<=', $end)
			->orderBy('id', 'desc')
			->get();
	}

	public function getRequestsForCountry($country)
	{
		return $this->whereIn('user_id', function ($query) use ($country) {
			$query->select('id')->from('users')->where('country', 'LIKE', '%' . $country . '%');
		})->orderBy('id', 'desc')
			->take(10)
			->get();
	}

	public function getRequestForDay($user_id, $date)
	{
		return $this->selectRaw('sales_report.date as d, sales_report.user_id as c, products_requested.product_id as p_id, SUM(products_requested.quantity) as q')
			->join('products_requested', 'products_requested.request_id', '=', 'sales_report.id')
			->where('sales_report.user_id', $user_id)
			->whereDate('sales_report.date', $date)
			->first();
	}

	public function getSalesForDay($team, $product_id, $date)
	{

		return $this->where('team', $team)
			->where('product_id', $product_id)
			->whereDate('date', $date)
			->sum('quantity');
	}

	public function getAllSalesMerchandiseByDate($date, $team)
	{
		$output = [];
		$product = new Product();
		$products = $product->getSorwatomProducts();
		$productsNumbers = $products->pluck('id')->toArray();

		foreach ($productsNumbers as $product_id) {
			$sales = $this->getSalesForDay($team, $product_id, $date);
			$name = $product->getProductByIdName($product_id)->name;
			$output[$name] = $sales;
		}

		return $output;
	}

	public function getPlaceSalesMerchandiseByDate($date, $team)
	{
		$result = $this->where('team', $team)
			->whereDate('date', $date)
			->first();

		if ($result) {
			return $result->place;
		}

		return null;
	}

	public function allSoldProductsId($product_id, $user_id)
	{
		return $this->selectRaw('SUM(quantity) as sum')
			->where('product_id', $product_id)
			->where('user_id', $user_id)
			->first();
	}

	public function saveSalesReport(
		int $user_id,
		int $product_id,
		int|float $quantity,
		string $place,
		int $stock_request_id,
		string $geolocation,
		string $client_name,
		string $client_phone,
		string $team
	) {

		return $this->create([
			'product_id' => $product_id,
			'user_id' => $user_id,
			'quantity' => $quantity,
			'place' => $place,
			'stock_request_id' => $stock_request_id,
			'geolocation' => $geolocation,
			'client_name' => $client_name,
			'client_phone' => $client_phone,
			'team' => $team,
		]);
	}
}
