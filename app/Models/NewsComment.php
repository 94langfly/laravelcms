<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsComment extends Model
{
    use HasFactory;
    protected $dates = ['created_at', 'updated_at'];
    protected $table = "news_comment";
    protected $guarded = ["id"];
	
    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
