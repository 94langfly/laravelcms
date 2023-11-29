<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
    protected $dates = ['created_at', 'updated_at'];
    protected $table = "news";
    protected $guarded = ["id"];
	
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function news_comment()
    {
        return $this->hasMany(NewsComment::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }
}
