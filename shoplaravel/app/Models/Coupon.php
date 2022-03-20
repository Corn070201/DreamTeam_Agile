<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'coupon_name','coupon_times','coupon_number','coupon_condition','coupon_code'
    ];
    protected $primaryKey = 'coupon_id';
    protected $table = 'tbl_coupon';
}
