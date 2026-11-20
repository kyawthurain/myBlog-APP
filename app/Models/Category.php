<?php

namespace App\Models;

use App\Models\User;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'title'
    ];
 
    public function users(){
        return $this->belongsToMany(User::class,'interests','category_id','user_id')->withTimestamps();
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

}
