<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StockReport
 * 
 * @property int $id
 * @property int $customer_id
 * @property Carbon $date
 * @property int $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class StockReport extends Model
{
	protected $table = 'stock_reports';

	protected $casts = [
		'customer_id' => 'int',
		'date' => 'datetime',
		'status' => 'int'
	];

	protected $fillable = [
		'customer_id',
		'date',
		'status'
	];


	public function productsReported()
	{
		return $this->hasMany(ProductReport::class, 'report_id');
	}

	public function saveStockReport($user_id, $productsReported = [])
	{
		$date = date("Y-m-d H:i:s");

		$stockReport = $this->create([
			'customer_id' => $this->customer_id,
			'date' => $date,
			'status' => 1,
		]);

		$or = new ObjectsUsersRelation();
		$or->saveObjectRelationship($stockReport->id, $user_id, 'stock_report');

		if (!empty($productsReported)) {

			foreach ($productsReported as $p) {

				$pr = new ProductReport();
				$pr->saveReportedProduct($p['product_id'], $p['qty'], $stockReport->id, $user_id);
			}
		}

		return $stockReport;
	}

	public function getReportsForCustomer($customer_id)
	{
		return $this->where('customer_id', $customer_id)
			->with('productsReported')
			->get();
	}

	public function getReports()
	{
		return $this->orderBy('id', 'desc')
			->take(10)
			->with('productsReported')
			->get();
	}

	public function getReportsByPeriod($start, $end)
	{
		return $this->whereBetween('date', [$start, $end])
			->orderBy('id', 'desc')
			->with('productsReported')
			->get();
	}

	public function getReportsForCountry(string $country)
	{
		return $this->whereIn('customer_id', function ($query) use ($country) {
			$query->select('id')->from('customers')->where('country', 'LIKE', '%' . $country . '%');
		})->orderBy('id', 'desc')
			->take(10)
			->with('productsReported')
			->get();
	}

	public function getReportForDay(int $customer_id, string $date, int $product_id)
	{
		return $this->selectRaw('stock_report.date as d, stock_report.customer_id as c,
                    products_reported.product_id as p_id, SUM(products_reported.quantity) as q')
			->join('products_reported', 'products_reported.report_id', '=', 'stock_report.id')
			->where('stock_report.customer_id', $customer_id)
			->whereDate('stock_report.date', $date)
			->where('products_reported.product_id', $product_id)
			->first();
	}

	public function getReportForPeriod(string $country, string $start, string $end)
	{
		return $this->selectRaw('DATE(stock_report.date) as d, SUM(products_reported.quantity) as q, products_reported.product_id')
			->join('products_reported', 'products_reported.report_id', '=', 'stock_report.id')
			->join('customers', 'stock_report.customer_id', '=', 'customers.id')
			->where('customers.country', 'LIKE', $country)
			->whereBetween('stock_report.date', [$start, $end])
			->groupBy('products_reported.product_id', 'DATE(stock_report.date)')
			->orderBy('DATE(stock_report.date)')
			->get();
	}

	public function getDailyReportByUser(int $user)
	{
		return $this->select('customers.name', 'customers.company', 'customers.phone', 'stock_report.id', 'customers.country', 'stock_report.date')
			->join('customers', 'stock_report.customer_id', '=', 'customers.id')
			->join('objects_users_relations', 'stock_report.id', '=', 'objects_users_relations.object_id')
			->where('objects_users_relations.user_id', $user)
			->where('objects_users_relations.object_type', 'stock_report')
			->orderBy('customers.name', 'asc')
			->get();
	}
}
