<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CommentService;

class CommentController extends Controller
{
    protected $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }
    public function addComment(Request $request, $id)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        try {
            $comment = $this->commentService->addCommentToPost($id, $validated);

            return response()->json([
                'status' => true,
                'message' => 'Comment added successfully.',
                'data' => $comment
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to add comment.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
