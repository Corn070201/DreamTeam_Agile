<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'category_id','product_name','brand_id','product_desc','product_content','product_price','product_image','product_status','product_sold'
    ];
    protected $primaryKey = 'product_id';
    protected $table = 'tbl_product';
}
