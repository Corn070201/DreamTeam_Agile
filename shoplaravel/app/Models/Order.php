<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'order_status','customer_id','shipping_id','order_code','order_date','created_at'
    ];
    protected $primaryKey = 'order_id';
    protected $table = 'tbl_order';
    
}
