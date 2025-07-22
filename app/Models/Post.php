<?php

namespace App\Models;

use App\Policies\PostPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
#[UsePolicy(PostPolicy::class)]

class Post extends Model
{
    //
    use HasFactory;

    use AuthorizesRequests;
    protected $fillable = [
      'title',
      'content',
      'category',
      'author_id',
  ];

    public function author()
{
    return $this->belongsTo(User::class, 'author_id');

}
public function comments()
{
    return $this->hasMany(Comment::class);
}
}
