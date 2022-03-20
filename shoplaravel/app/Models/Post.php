<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable=[
        'post_title','post_slug','post_desc','post_content','post_meta_desc','post_meta_keywords','post_status','post_image','cate_post_id'
    ];
    protected $primaryKey = 'post_id';
    protected $table = 'tbl_posts';
    public function cate_post(){
        return $this->belongsto('App\Models\Category_Post','cate_post_id');
    }
}
