<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeship extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'fee_matp','fee_maqh','fee_xaid','fee_ship'
    ];
    protected $primaryKey = 'fee_id';
    protected $table = 'tbl_fee_ship';
    public function city(){
        return $this->belongsto('App\Models\City','fee_matp');
    }
    public function province(){
        return $this->belongsto('App\Models\Province','fee_maqh');
    }
    public function wards(){
        return $this->belongsto('App\Models\Wards','fee_xaid');
    }
}
