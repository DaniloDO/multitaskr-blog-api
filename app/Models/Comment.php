<?php

namespace App\Models;

use App\Models\Traits\Uidable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, Uidable, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */ 
    protected $guarded = [ 'id', 'uid', 'deleted_at', 'updated_at'];

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
        'id'
    ];

    /**
     * Get the user from this comment
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the post from this comment
     */ 
    public function post() {
        return $this->belongsTo(Post::class);
    }

}
