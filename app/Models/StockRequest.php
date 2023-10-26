<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StockRequest
 * 
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property float $quantity
 * @property Carbon $date
 * @property int $proved
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 * @property Collection|SalesReport[] $sales_reports
 *
 * @package App\Models
 */
class StockRequest extends Model
{
	protected $table = 'stock_requests';

	protected $casts = [
		'product_id' => 'int',
		'user_id' => 'int',
		'quantity' => 'float',
		'date' => 'datetime',
		'proved' => 'int'
	];

	protected $fillable = [
		'product_id',
		'user_id',
		'quantity',
		'date',
		'proved'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function sales_reports()
	{
		return $this->hasMany(SalesReport::class);
	}


	public function productsRequested()
    {
        return $this->hasMany(ProductRequested::class, 'request_id');
    }

    public function saveStockRequest($user_id)
    {
        date_default_timezone_set("Africa/Bujumbura");
        $date = date("Y-m-d H:i:s");
        
        $stockRequest = $this->create([
            'user_id' => $this->user_id,
            'date' => $date,
            'status' => 0,
        ]);

        if (!empty($this->products_requested)) {
            foreach ($this->products_requested as $p) {
                $pr = new StockRequest::create($p);
                $pr->saveProductRequested($p['product_id'], $p['qty'], $stockRequest->id);
            }
        }

        return $stockRequest;
    }

    public function sumStock($product_id, $user_id)
    {
        return $this->selectRaw('SUM(quantity) as sum')
            ->where('product_id', $product_id)
            ->where('user_id', $user_id)
            ->first();
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
        })
        ->orderBy('id', 'desc')
        ->take(10)
        ->get();
    }

    public function getRequestForDay($user_id, $date)
    {
        return $this->selectRaw('stock_request.date as d, stock_request.user_id as c,
                products_requested.product_id as p_id, SUM(products_requested.quantity) as q')
            ->join('products_requested', 'products_requested.request_id', '=', 'stock_request.id')
            ->where('stock_request.user_id', $user_id)
            ->whereDate('stock_request.date', $date)
            ->first();
    }
}
