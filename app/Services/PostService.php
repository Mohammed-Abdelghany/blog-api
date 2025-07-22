<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class PostService
{
  public function getFilteredPosts(Request $request, $user)
  {
    $query = Post::query();

    if ($user->role->value !== 'admin') {
        $query->where('author_id', $user->id);
    }

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%$search%")
              ->orWhereHas('author', function($q2) use ($search) {
                  $q2->where('name', 'like', "%$search%");
              });
        });
    }
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    if ($request->filled('author_id')) {
        $query->where('author_id', $request->author_id);
    }

    if ($request->filled('date_from') && $request->filled('date_to')) {
        $query->whereBetween('created_at', [$request->date_from, $request->date_to]);
    }

    return $query->with(['author:id,name'])->latest()->paginate(10);
  }

  public function getPostWithAuthor($id)
  {
      return Post::with('author')->findOrFail($id);
  }


public function create(array $data)
{
    $post = Post::create($data);
    return $post;

}


}
