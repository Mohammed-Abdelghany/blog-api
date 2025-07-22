<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function addCommentToPost($postId, array $data)
    {
        // Find post or fail
        $post = Post::findOrFail($postId);

        return $post->comments()->create([
            'content' => $data['content'],
            'user_id' => Auth::id(),
        ]);
    }
}
