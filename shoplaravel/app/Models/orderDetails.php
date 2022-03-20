<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderDetails extends Model
{
    use HasFactory;
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
       'order_code','product_coupon','product_id','product_name','product_price','product_sales_quantity'
    ];
    protected $primaryKey = 'order_details_id';
    protected $table = 'tbl_order_details';
    public function product(){
        return $this->belongsto('App\Models\Product','product_id');
    }
}
