<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductsOrdered
 * 
 * @property int $id
 * @property int $product_id
 * @property int $order_id
 * @property float $qty
 * @property float $price
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Product $product
 * @property Order $order
 * @property ConfirmedOrder $confirmed_order
 *
 * @package App\Models
 */
class ProductsOrdered extends Model
{
	protected $table = 'products_ordered';

	protected $casts = [
		'product_id' => 'int',
		'order_id' => 'int',
		'qty' => 'float',
		'price' => 'float'
	];

	protected $fillable = [
		'product_id',
		'order_id',
		'qty',
		'price'
	];

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function order()
	{
		return $this->belongsTo(Order::class);
	}

	public function confirmed_order()
	{
		return $this->hasOne(ConfirmedOrder::class);
	}


	public function saveOrderedProduct($product_id, $order_id, $qty, $price)
	{
		$productOrdered = new ProductsOrdered();
		$productOrdered->product_id = $product_id;
		$productOrdered->order_id = $order_id;
		$productOrdered->qty = $qty;
		$productOrdered->price = $price;
		$productOrdered->save();

		return $productOrdered;
	}

	public function getProductsForOrder($order_id)
	{
		return ProductsOrdered::join('products', 'products.id', '=', 'products_ordered.product_id')
			->select('products_ordered.id', 'products_ordered.product_id', 'products_ordered.order_id', 'products_ordered.qty', 'products_ordered.price', 'products.name')
			->where('products_ordered.order_id', $order_id)
			->get();
	}

	public function getProductsIDsForOrder($order_id, $product_id)
	{
		return ProductsOrdered::where('order_id', $order_id)
			->where('product_id', '!=', $product_id)
			->get(['product_id', 'qty']);
	}

	public function updateOrderFromMobile(int|float $price, int $product_id, int $order_id, int|float $qty)
	{
		$orderUpdate = ProductsOrdered::where('order_id', $order_id)
			->where('product_id', $product_id)
			->update(['qty' => $qty]);

		if ($orderUpdate) {
			$orderTotal = ProductsOrdered::where('order_id', $order_id)->sum('qty * price');
			$orderUpdate = Order::where('id', $order_id)
				->update(['amount' => $orderTotal]);

			return $orderUpdate;
		} else {
			return false;
		}
	}

	public function countMostOrderedProducts(int $product_id)
	{
		return ProductsOrdered::where('product_id', $product_id)
			->groupBy('product_id')
			->orderByRaw('count(*) desc')
			->count();
	}
}
