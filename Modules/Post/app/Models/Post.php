<?php

namespace Modules\Post\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\Post\Database\Factories\PostFactory;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];

    // protected static function newFactory(): PostFactory
    // {
    //     return PostFactory::new();
    // }


    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
