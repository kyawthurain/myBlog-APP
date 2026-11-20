<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile(){
        return $this->hasMany(Profile::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function bookmarks(){
        return $this->belongsToMany(Post::class,'bookmarks','user_id','post_id')->withTimestamps();
    }
    public function interests(){
        return $this->belongsToMany(Category::class,'interests','user_id','category_id')->withTimestamps();
    }

    public function reactPosts(){
        return $this->belongsToMany(Post::class,'react_posts','user_id','post_id')->withTimestamps();
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

}
