<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPage extends Model
{
    use HasFactory;
    protected $dates = ['created_at', 'updated_at'];
    protected $table = "custom_pages";
    protected $guarded = ["id"];
}
