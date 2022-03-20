<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_Product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'category_name','category_status','category_desc','meta_keywords'
    ];
    protected $primaryKey = 'category_id';
    protected $table = 'tbl_category_product';
}
