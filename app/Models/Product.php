<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * 
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $price
 * @property string $remarks
 * @property int $added_by
 * @property int $status
 * @property string $gallery
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Country[] $countries
 * @property Collection|ProductReport[] $product_reports
 * @property Collection|Order[] $orders
 * @property Collection|SalesReport[] $sales_reports
 * @property Collection|StockRequest[] $stock_requests
 *
 * @package App\Models
 */
class Product extends Model
{
	protected $table = 'products';

	protected $casts = [
		'added_by' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'type',
		'price',
		'remarks',
		'added_by',
		'status',
		'gallery'
	];

	public function countries()
	{
		return $this->belongsToMany(Country::class, 'product_country_prices')
					->withPivot('id', 'price', 'status')
					->withTimestamps();
	}

	public function product_reports()
	{
		return $this->hasMany(ProductReport::class);
	}

	public function orders()
	{
		return $this->belongsToMany(Order::class, 'products_ordered')
					->withPivot('id', 'qty', 'price')
					->withTimestamps();
	}

	public function sales_reports()
	{
		return $this->hasMany(SalesReport::class);
	}

	public function stock_requests()
	{
		return $this->hasMany(StockRequest::class);
	}



	public function objectRelationship()
    {
        return $this->hasMany(ObjectRelationship::class, 'object_id')->where('object_type', 'product');
    }

    public function sorwatomProducts()
    {
        return $this->belongsToMany(SorwatomProduct::class, 'sorwatom_products', 'product_id', 'id');
    }

    public function updateField($field, $value)
    {
        $this->$field = $value;
        return $this->save();
    }

    public static function updateGeneral($attrs)
    {
        $product = self::find($attrs['id']);
        if ($product) {
            foreach ($attrs as $field => $value) {
                $product->$field = $value;
            }
            return $product->save();
        }

        return false;
    }

    public static function getProductById($id)
    {
        return self::find($id);
    }

    public static function getProductByIdName($id)
    {
        return self::find($id, ['name']);
    }

    public static function getProductByIdPrice($id)
    {
        return self::find($id, ['price']);
    }

    public static function getAllProducts()
    {
        return self::orderBy('date_creation', 'ASC')->get();
    }

    public function saveProduct($user_id)
    {
        $this->added_by = $user_id;
        return $this->save();
    }

    public function addSorwatomProduct()
    {
        $this->save();
        $sorwatomProduct = new SorwatomProduct();
        $sorwatomProduct->product_id = $this->id;
        return $sorwatomProduct->save();
    }

    public static function getSorwatomProducts()
    {
        return self::select('products.*', 'sorwatom_products.product_id')
            ->join('sorwatom_products', 'products.id', '=', 'sorwatom_products.product_id')
            ->orderBy('date_creation')
            ->get();
    }
}
