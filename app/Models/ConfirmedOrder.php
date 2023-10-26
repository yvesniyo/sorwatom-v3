<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ConfirmedOrder
 * 
 * @property int $confirmed_order_id
 * @property int $products_ordered_id
 * @property int $qty
 * @property Carbon $datetime
 * @property int $status
 * @property string $invoice_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property ProductsOrdered $products_ordered
 *
 * @package App\Models
 */
class ConfirmedOrder extends Model
{
	protected $table = 'confirmed_order';
	public $incrementing = false;

	protected $casts = [
		'confirmed_order_id' => 'int',
		'products_ordered_id' => 'int',
		'qty' => 'int',
		'datetime' => 'datetime',
		'status' => 'int'
	];

	protected $fillable = [
		'confirmed_order_id',
		'products_ordered_id',
		'qty',
		'datetime',
		'status',
		'invoice_number'
	];

	public function products_ordered()
	{
		return $this->belongsTo(ProductsOrdered::class);
	}


	
    public function saveConfirmOrder(array $data)
    {
        return $this->create($data);
    }

    public function getConfirmOrderByOrder(int $order_id)
    {
        return $this->select('confirmed_order.products_ordered_id', 'confirmed_order.qty', 'confirmed_order.datetime', 'products_ordered.product_id', 'products_ordered.order_id')
            ->join('products_ordered', 'confirmed_order.products_ordered_id', '=', 'products_ordered.id')
            ->where('products_ordered.order_id', $order_id)
            ->orderBy('confirmed_order.confirmed_order_id', 'ASC')
            ->get();
    }

    public function getConfirmOrderById()
    {
        return $this->select('confirmed_order.products_ordered_id', 'confirmed_order.qty', 'confirmed_order.datetime', 'products_ordered.product_id', 'products_ordered.order_id')
            ->join('products_ordered', 'confirmed_order.products_ordered_id', '=', 'products_ordered.id')
            ->orderBy('confirmed_order.confirmed_order_id', 'DESC')
            ->get();
    }

    public function getProductsOrderId(int $products_ordered_id,int $product_id)
    {
        return $this->where('id', $products_ordered_id)
            ->where('product_id', $product_id)
            ->get();
    }

    public function getDeliveryReport(string $start,string $end)
    {
        return $this->select('*')
            ->join('loaded_order', 'orders.datetime', '>=', $start)
            ->where('loaded_order.datetime', '<=', $end)
            ->get();
    }

    public function getDeliveryQuantity(int $order_id)
    {
        return $this->select('confirmed_order.qty')
            ->join('products_ordered', 'products_ordered.id', '=', 'confirmed_order.products_ordered_id')
            ->where('products_ordered.order_id', $order_id)
            ->sum('qty');
    }

}
