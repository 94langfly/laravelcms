<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $dates = ['created_at', 'updated_at'];
    protected $table = "category";
    protected $guarded = ["id"];
	
    public function news()
    {
        return $this->hasMany(News::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }
}
