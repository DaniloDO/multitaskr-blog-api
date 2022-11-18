<?php

namespace App\Models;

use App\Models\Traits\Sluggable;
use App\Models\Traits\Uidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, Uidable, Sluggable, SoftDeletes;


    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */ 
    protected $guarded = ['id', 'uid', 'slug', 'deleted_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $cast = [
        'published_at' => 'datetime'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'published_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'user_id'
    ];

    /**
     * Get all the categories from this post
     */
    public function categories() 
    {
        return $this->belongsToMany(Category::class);
    } 

    /**
     * Get all the comments from this post
     */
    public function comments() 
    {
        return $this->hasMany(Comment::class);
    } 

    /**
     * Get the user from this post 
     */
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected function slug() 
    {
        return 'title';
    }


}
