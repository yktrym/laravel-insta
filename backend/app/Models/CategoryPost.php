<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryPost extends Model
{
    use HasFactory;

    protected $table = "category_post";
    protected $fillable = ['post_id', 'category_id'];
    public $timestamps = false;

    # To get the category name
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
