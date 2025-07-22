<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use AuthorizesRequests;
  
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    public function index(Request $request)
    {
        $posts = $this->postService->getFilteredPosts($request, auth()->user());
    
      
      if ($posts->total() === 0) {
          return response()->json([
              'status' => true,
              'message' => 'No posts found.',
          ]);
      }
  
      return response()->json([
          'status' => true,
          'message' => 'Posts retrieved successfully',
          'data' => $posts,
      ]);
    }
    
    public function store(PostCreateRequest $request)
    {
      $this->authorize('create', Post::class);
        $data = $request->validated();
        $data['author_id'] = auth()->id(); 
        $post = $this->postService->create($data);
        return response()->json($post, 200);
    }
    

    public function show($id)
    {
        $post = $this->postService->getPostWithAuthor($id);
        return response()->json([
            'status' => true,
            'message' => 'Post retrieved successfully',
            'data' => $post,
        ]);
    }

  
    public function update(PostUpdateRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        $data = $request->validated();
        $post->update($data);
        return response()->json(['status' => true, 'message' => 'Post updated', 'data' => $post]);
    }

  
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return response()->json(['status' => true, 'message' => 'Post deleted']);
    }

  
}
