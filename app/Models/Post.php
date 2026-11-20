<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use app\Models\Category;
use App\Models\User;
use App\Models\Comment;


class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    protected $fillable = [
        'title','content','user_id','slug','featured_photo','category_id','reaction_count','liked'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

      public function bookmarkedBy(){
    return $this->belongsToMany(User::class,'bookmarks','post_id','user_id')->withTimestamps();
   }

    public function reactedBy(){
        return $this->belongsToMany(User::class,'react_posts','post_id','user_id')->withTimestamps();
    }

     public function comments(){
        return $this->hasMany(Comment::class);
    }
}
